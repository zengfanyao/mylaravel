<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Database\Schema\Blueprint;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
