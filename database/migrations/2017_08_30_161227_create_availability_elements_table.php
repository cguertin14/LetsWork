<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailabilityElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availability_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('begin');
            $table->dateTime('end');
            $table->integer('availability_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('availability_id')->references('id')->on('availabilities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availability_elements');
    }
}
