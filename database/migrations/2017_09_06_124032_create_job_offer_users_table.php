<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobOfferUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offer_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_offer_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->binary('letter')->nullable();
            $table->boolean('accepted')->nullable();
            $table->boolean('interview')->nullable();
            $table->timestamps();

            $table->foreign('job_offer_id')->references('id')->on('job_offers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        DB::statement('alter table job_offer_user MODIFY letter LONGBLOB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_offer_user');
    }
}
