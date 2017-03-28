<?php
namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class SocketController extends Controller
{
    //获取token
    public function token()
    {
        $token=\App\Logic\SocketLogic::getToken();
        return $this->response(['token'=>$token]);
    }

    //验证token
    public function check_token()
    {
        $this->verify([
            'token' => ''
        ],'POST');

        $res=\App\Logic\SocketLogic::checkToken($this->verifyData['token']);
        if(!$res){
            throw new ApiException('获取token失败');
        }
        return $this->response($res);
    }
}