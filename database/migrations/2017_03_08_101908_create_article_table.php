<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->comment('标题');
            $table->string('author', 255)->nullable()->comment('作者');
            $table->string('cover', 255)->nullable()->comment('封面url');
            $table->mediumText('content')->comment('正文');
            $table->integer('cat_id')->comment('分类id');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->tinyInteger('is_on')->default(1);

            

            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}