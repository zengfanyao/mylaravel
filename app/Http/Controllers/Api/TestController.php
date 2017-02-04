<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index(Request $request)
    {


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
