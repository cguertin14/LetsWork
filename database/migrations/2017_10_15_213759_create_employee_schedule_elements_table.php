<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeScheduleElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_schedule_element', function (Blueprint $table) {
            $table->integer('schedule_element_id')->unsigned()->index();
            $table->integer('employee_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('schedule_element_id')->references('id')->on('schedule_elements')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_schedule_element');
    }
}
