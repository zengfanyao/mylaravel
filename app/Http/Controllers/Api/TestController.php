<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\BaseController;

class TestController extends BaseController
{

    public function index()
    {
        $data=array(
            'str' => 'hello world'
        );

        return $this->response($data);
    }

}
