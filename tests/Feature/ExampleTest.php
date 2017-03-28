<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    protected $testUserId = 1;      //调试testuser模式,用户id

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

        $response =  $this->json('GET', '/api/test?usertest='.$this->testUserId,array(),$this->getSessionHeader());

        //var_dump($response->baseResponse->getContent());
        //var_dump($response->baseResponse->getOriginalContent());

        $response->assertStatus(200)->assertJson(['status'=>true]);
    }
}
