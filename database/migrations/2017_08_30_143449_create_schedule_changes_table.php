<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('confirmed')->default(0);
            $table->integer('employee_to_change_id')->unsigned()->index();
            $table->integer('employee_to_accept_id')->unsigned()->index();
            $table->integer('schedule_element_id')->unsigned()->index();
            $table->integer('special_role_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('employee_to_change_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('employee_to_accept_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('schedule_element_id')->references('schedule_element_id')->on('schedule_element_special_roles')->onDelete('cascade');
            $table->foreign('special_role_id')->references('special_role_id')->on('schedule_element_special_roles')->onDelete('cascade');
        });

        //DB::statement('ALTER TABLE schedule_changes ADD CONSTRAINT check_confirmed CHECK (confirmed = 0 OR confirmed = 1);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_changes');
    }
}
