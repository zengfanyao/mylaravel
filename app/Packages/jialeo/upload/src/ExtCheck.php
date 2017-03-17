<?php

namespace JiaLeo\Upload;


use App\Exceptions\ApiException;

class ExtCheck
{


    /**
     * 扩展名组
     * @var array
     */
    public static $extGroup = [
        //图片组
        'image' => [
            'jpeg' => 'image/jpeg',
            'jpg' => ['image/jpg', 'image/jpeg'],
            'png' => 'image/png',
            'gif' => 'image/gif',
        ]
    ];

    public static $extLink =[
        'jpeg' => 'image/jpeg',
        'jpg' => ['image/jpg', 'image/jpeg'],
        'png' => 'image/png',
        'gif' => 'image/gif'
    ];


    /**
     * 扩展名组验证
     * @param $file_type
     * @param $ext
     * @param string $group_name
     * @return bool
     * @throws ApiException
     */
    public static function extLimitGroup($file_type, $ext, $group_name = 'image')
    {
        if(!isset(self::$extGroup[$group_name])){
            throw new ApiException('不存在扩展名组验证!');
        }

        $rule = self::$extGroup[$group_name];

        if(!isset($rule[$ext])){
            return false;
        }

        if(is_array($rule[$ext])){
            if(in_array($file_type,$rule[$ext])){
                return true;
            }
        }
        else{
            if($file_type != $rule[$ext]){
                return true;
            }
        }

        return false;
    }

    /**
     * 验证文件类型
     * @param $file_type
     * @param string $group_name
     * @return bool
     * @throws ApiException
     */
    public static function checkFileTypeOfGroup($file_type, $group_name = 'image'){
        if(!isset(self::$extGroup[$group_name])){
            throw new ApiException('不存在扩展名组验证!');
        }

        $rule = self::$extGroup[$group_name];

        foreach($rule as $v){
            if(is_array($v)){
                if(in_array($file_type,$v)){
                    return true;
                }
            }
            else{
                if($file_type == $v){
                    return true;
                }
            }
        }

        throw new ApiException('不支持的文件类型!');
    }


}