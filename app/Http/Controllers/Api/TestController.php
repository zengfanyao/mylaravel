<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Model\AdminModel;

class TestController extends Controller
{

    public function index()
    {
        $data=array(
            'str' => 'hello world'
        );

        return $this->response($data);
    }

}
