<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Database\Schema\Blueprint;

class TestController extends Controller
{
    public function index()
    {
        $data = array(
            'str' => 'hello world2'
        );


        \Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        return $this->response($data);
    }

}
