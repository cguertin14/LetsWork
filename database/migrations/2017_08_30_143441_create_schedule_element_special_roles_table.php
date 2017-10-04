<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleElementSpecialRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_element_special_role', function (Blueprint $table) {
            $table->integer('schedule_element_id')->unsigned()->index();
            $table->integer('special_role_id')->unsigned()->index();
            $table->integer('employee_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('schedule_element_id')->references('id')->on('schedule_elements')->onDelete('cascade');
            $table->foreign('special_role_id')->references('id')->on('special_roles')->onDelete('cascade');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('schedule_element_special_role');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
