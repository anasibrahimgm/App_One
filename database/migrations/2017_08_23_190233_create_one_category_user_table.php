<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOneCategoryUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('one_category_user', function(Blueprint $table) {
          $table->increments('id');

          $table->integer('category_id')->unsigned();
          $table->foreign('category_id')->references('id')->on('one_categories');

          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('one_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('one_category_user');
    }
}
