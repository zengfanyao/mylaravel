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

        dump(app('JiaLeo\Core\Dd'));

        return $this->response($data);
    }

}
