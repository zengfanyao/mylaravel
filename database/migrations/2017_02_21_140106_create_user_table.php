<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id')->comment('用户ID,主键自增');
            $table->string('email', 32)->nullable()->comment('用户的登录邮箱');
            $table->string('headimg', 255)->nullable()->comment('头像');
            $table->string('username', 32)->nullable()->comment('用户名称，方便用户之间辨认');
            $table->string('last_login_ip', 16)->nullable()->comment('用户最后一次登录的时间');
            $table->unsignedInteger('created_at')->comment('创建时间');
            $table->unsignedInteger('updated_at')->comment('更新时间');
            $table->unsignedTinyInteger('is_on')->default(1)->comment('用户状态。0为已删除，1为正常');

            

            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
