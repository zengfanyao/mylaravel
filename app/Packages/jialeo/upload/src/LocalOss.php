<?php
namespace JiaLeo\Upload;

use App\Exceptions\ApiException;

class LocalOss
{
    private $filepath; //上传目录
    private $tmpPath; //PHP文件临时目录
    private $blobNum; //第几个文件块
    private $totalBlobNum; //文件块总数
    private $fileName; //文件名

    public function __construct(/*$tmpPath, $blobNum, $totalBlobNum, $fileName*/)
    {
        /*$this->filepath = base_path().'/storage';
        $this->tmpPath = $tmpPath;
        $this->blobNum = $blobNum;
        $this->totalBlobNum = $totalBlobNum;
        $this->fileName = $fileName;

        $this->moveFile();
        $this->fileMerge();*/
    }

    /**
     * 获取分块id
     * @param \App\Model\UploadModel $upload_model
     * @param $total_size
     * @param $part_size
     * @param $file_type
     * @param $dir
     * @param $filename
     * @param $callback
     * @param bool $is_multi
     * @param string $part_temp_dir
     * @return bool
     * @throws ApiException
     */
    public function getUploadId($upload_model = \App\Model\UploadModel::class, $total_size, $part_size, $file_type, $dir, $filename, $upload_host,$is_multi = false,$part_temp_dir = '')
    {
        $data = compact('total_size', 'part_size', 'file_type', 'filename', 'dir', 'path_temp_dir');
        $data['is_multi'] = 0;
        //计算分块数量
        $data['part_num'] = ceil($data['total_size'] / $data['part_size']);
        $data['origin_filename'] = $data['filename'];
        $data['filename'] = md5(time() . rand(10000, 99999) . $data['origin_filename']);
        $data['type'] = 'local';

        //分析扩展名
        $ext = pathinfo($data['origin_filename'])['extension'];
        if (empty($ext)) {
            throw new ApiException('文件扩展名获取失败!');
        }

        //完整路径
        $data['path'] = '/' . $data['dir'] . $data['filename'] . '.' . $ext;

        //如果是分块且分块数大于1
        if ($is_multi && $data['part_num'] > 1) {

            $multi_path = trim($data['path'], '/');

            $data['part_temp_dir'] = 'multiupload/'.date('Ymd').'/'.$part_temp_dir;

            $data['is_multi'] = 1;
        }

        $upload_model = new $upload_model();
        set_save_data($upload_model, $data);
        $upload_model->save();
        $upload_id = $upload_model->id;

        $sign = array();
        if ($is_multi && $data['part_num'] > 1) {
            //生成各块签名
            for ($i = 1; $i <= $data['part_num']; $i++) {
                $temp_sign['is_multi'] = 1;
                $temp_sign['type'] = 'local';
                $temp_sign['host'] = $upload_host;
                $temp_sign['upload_id'] = $upload_id;
                $temp_sign['part_now'] = $i;
                $sign[] = $temp_sign;
                unset($temp_sign);
            }
        } else {
            $temp_sign['is_multi'] = 0;
            $temp_sign['type'] = 'local';
            $temp_sign['host'] = $upload_host;
            $temp_sign['upload_id'] = $upload_id;
            $temp_sign['part_now'] = 1;
            $sign[] = $temp_sign;
            unset($temp_sign);
        }

        $this->uploadId = $upload_id;
        $this->partNum = $data['part_num'];
        $this->uploadSign = $sign;

        return true;
    }

    public function updatePart($upload_model = \App\Model\UploadModel::class,$upload_id,$part_now,$is_upload=false)
    {
        //查询数据库
        $field = ['id', 'dir', 'part_num', 'part_now', 'filename', 'path', 'is_multi', 'oss_upload_id', 'oss_part_upload_ids', 'part_temp_dir'];
        $upload_info = $upload_model::where('is_on', 1)->where('status', 0)->where('id', $upload_id)->first($field);
        if (!$upload_info) {
            throw new ApiException('上传id不符合');
        }

        //判断保存路径
        if(!$upload_info->is_multi && !$is_upload){
            $save_path = public_path().$upload_info->path;
        }
        else{
            $save_path = storage_path().'/'.$upload_info->part_temp_dir.$upload_info->filename.'_'.$part_now;
        }
        load_helper('File');
        if(!dir_exists(dirname($save_path))){
            throw new ApiException('文件保存失败!');
        }

        $move=move_uploaded_file(request()->file('file')->getPathname(),$save_path);
        if(!$move){
            throw new ApiException('文件保存失败!');
        }

        if ($upload_info->is_multi) {
            if ($upload_info->part_now + 1 != $part_now) {
                throw new ApiException('上传分块错误');
            }

            $update_data = ['part_now' => $part_now];
            $result = [];

            if($upload_info->part_num == $part_now){
                $update_data['status'] = 1;

                $file_path=storage_path().'/'.$upload_info->part_temp_dir.$upload_info->filename.'_1';
                $fp = fopen($file_path ,"a+");

                //合并文件
                for($i = 1;$i<=$upload_info->part_num;$i++){
                    if($i == 1){
                        continue;
                    }

                    $get_path = storage_path().'/'.$upload_info->part_temp_dir.$upload_info->filename.'_'.$i;
                    $fp2 = fopen($get_path, "r");
                    $content = fread($fp2, filesize($get_path));
                    fwrite($fp, $content);
                    fclose($fp2);

                    //删除分块
                    unlink($get_path);
                }
            }
        } else {
            $update_data = ['status' => 1, 'part_now' => 1];
            $result = [
                'url' =>   $upload_info->path
            ];
        }


        if($upload_info->part_num == $part_now && $is_upload){

        }





        $update = $upload_model::where('id', $upload_id)->update($update_data);

        return $result;
    }


}