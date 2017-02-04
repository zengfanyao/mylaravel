<?php
namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use OSS\OssClient;

class UploadController extends Controller
{

    /**
     * 第一步:获取上传id
     */
    public function getUploadID(Request $request)
    {
        $this->verify([
            'total_size' => 'egnum',
            'part_size' => 'egnum',
            'file_type' => '',
            'filename' => '',
            'upload_type' => 'in:banner:article:activity',
            'upload_setting' => 'in:cloud:local'
        ], 'POST');
        $data = $this->verifyData;


        //此处作权限控制
        switch ($data['upload_type']) {
            case 'banner' :
                $upload_setting = 'cloud';
                break;
            case 'article' :
                $upload_setting = 'local';
                break;
            case 'activity' :
                $upload_setting = $data['upload_setting'];
                break;
            default :
                throw new ApiException('错误的上传类型!', 'UPLOAD_ERROR');
        }

        $dir = 'mutest/';

        if ($upload_setting == 'cloud') {
            $aliyun_obj = new \JiaLeo\Upload\AliyunOss();
            $callback = 'http://hanzikeji.imwork.net:9999/api/upload/callback';

            $aliyun_obj->getUploadId(\App\Model\UploadModel::class, $data['total_size'], $data['part_size'], $data['file_type'], $dir, $data['filename'], $callback, true);
            $upload_sign = $aliyun_obj->uploadSign;
            $upload_id = $aliyun_obj->uploadId;
            $part_num = $aliyun_obj->partNum;
        } else {
            $upload_host = $request->getSchemeAndHttpHost() . '/api/files';

            $local_obj = new \JiaLeo\Upload\LocalOss();
            $local_obj->getUploadId(\App\Model\UploadModel::class, $data['total_size'], $data['part_size'], $data['file_type'], $dir, $data['filename'], $upload_host, true);
            $upload_sign = $local_obj->uploadSign;
            $upload_id = $local_obj->uploadId;
            $part_num = $local_obj->partNum;
        }

        return $this->response([
            'upload_id' => $upload_id,
            'part_num' => $part_num,
            'upload_setting' => $upload_setting
        ],
            $upload_sign);
    }

    /**
     *  完成
     */
    public function putUploadComplete($id)
    {
        $this->verifyId($id);

        $obj = new \JiaLeo\Upload\AliyunOss();
        $obj->multiUploadComplete(\App\Model\UploadModel::class, $id);

        return $this->response();
    }

    /**
     *  上传回调
     */
    public function uploadCallback()
    {
        $obj = new \JiaLeo\Upload\AliyunOss();
        $sign = $obj->notify(\App\Model\UploadModel::class);
        return $sign;
    }

    public function upload(Request $request)
    {
        $this->verify([
            'upload_id' => 'egnum',
            'part_now' => 'egnum'

        ], 'POST');
        $data = $this->verifyData;

        $local_obj = new \JiaLeo\Upload\LocalOss();
        $result = $local_obj->updatePart(\App\Model\UploadModel::class, $data['upload_id'], $data['part_now']);

        return $this->response($result);

        //dump($request->file());
        //var_dump($_FILES);
    }


}
