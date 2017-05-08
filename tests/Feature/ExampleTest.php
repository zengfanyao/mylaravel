<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    public $testUserId = 1;      //调试testuser模式,用户id
    public $url = '/api/test';

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->send('GET',$this->url,$this->testUserId,array('test'=>11111),array());

        //var_dump($response->baseResponse->getContent());
        //var_dump($response->baseResponse->getOriginalContent());

        $response->assertStatus(200)->assertJson(['status'=>true]);

        $this->assertDatabaseHas('admin_user',[
            'account' => 'admin'
        ]);
    }
}
