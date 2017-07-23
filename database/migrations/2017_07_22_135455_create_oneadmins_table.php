<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOneadminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('one_admins', function (Blueprint $table) {
             $table->increments('id');//make one_admins out of regular users? regular users + priviliges
             $table->string('name');
             $table->string('email')->unique();
             $table->string('password');
             $table->enum('role', ['1', '2', '3']);
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
         Schema::dropIfExists('one_admins');
     }
}
