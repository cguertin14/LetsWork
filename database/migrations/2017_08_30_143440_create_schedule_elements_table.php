<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('begin');
            $table->dateTime('end');
            $table->integer('schedule_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_elements');
    }
}
