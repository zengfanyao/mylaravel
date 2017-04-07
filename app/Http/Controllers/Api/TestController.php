<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index()
    {
        $data = array(
            'str' => 'hello world'
        );

        return $this->response($data);
    }
}
