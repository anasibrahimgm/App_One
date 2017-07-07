<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_one', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique()->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->unique();
            //$table->string('phone')->unique()->nullable();
            $table->string('password')->nullable();//nullable for providers
            $table->string('avatar')->default('avatar.png');
            $table->integer('posts')->default(0);
            $table->integer('comments')->default(0);
            $table->integer('replies')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_one');
    }
}
