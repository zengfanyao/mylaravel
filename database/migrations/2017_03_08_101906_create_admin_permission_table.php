<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateAdminPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('code', 255)->nullable()->comment('规则代码');
            $table->string('description', 255)->nullable()->comment('描述');
            $table->integer('parent_id')->comment('父级id');
            $table->tinyInteger('level')->default(2)->comment('层级，1级为组，2级为权限');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->unsignedTinyInteger('is_on')->default(1);

            

            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_permission');
    }
}