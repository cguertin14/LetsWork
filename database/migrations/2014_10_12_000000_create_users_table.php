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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone_number');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('slug');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

  //          $table->foreign('photo_id')->references('id')->on('files')->onDelete('cascade');
        });

//        $table->string('phone_number');
//        $table->string('first_name');
//        $table->string('last_name');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
