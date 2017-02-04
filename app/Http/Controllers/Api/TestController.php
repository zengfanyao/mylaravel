<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\AdminModel;
use App\Model\UserModel;

class TestController extends Controller
{

    public function index()
    {
        $data = array(
            'str' => 'hello world'
        );

        /*$result = \Sms::send('15918721789','SMS_40550018',array('name' => '测试', 'bill_num' => '20176677889922'));
        dump($result);
        dump(\Sms::getErrorMsg(),\Sms::getCode());*/

        //dd(\Sms::aaa());
        // $code=Sms->code;  //获取一个6为随机数，可用于验证码
        //$result=$sms_obj->send('15918721789','SMS_40550018',array('name' => '测试', 'bill_num' => '20176677889922'));

        //dd(UserModel::getShareConnection(40));
        //dump(UserModel::getSharingConnection(2)->find(2));

        $aa = new \JiaLeo\Excel\Excel();
        //dump($aa);

        $export_data = array(

            array(
                '订单号', '支付时间', '商品id', '商品名称'
            ),

            array(
                '1',
                2,
                array(
                    '10', '11'
                ),
                array(
                    '商品1', '商品2'
                )
            ),
            array(
                '12222',
                211111111,
                12,
                '商品3'
            )
        );

        //$result= $aa -> export('aaaa',$export_data,true);

        //dump($result);

        $aa -> setCreator(123);


        //return $this->response($data);
    }

    public function index2()
    {
        $data = array(
            'str' => 'hello world2'
        );

        //dd(UserModel::getShareConnection(40));
        //dump(UserModel::getSharingConnection(2)->find(2));

        return $this->response($data);
    }

}
