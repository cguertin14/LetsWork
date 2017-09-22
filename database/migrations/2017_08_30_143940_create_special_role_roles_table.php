<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialRoleRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_role_role', function (Blueprint $table) {
            $table->integer('special_role_id')->unsigned()->index();
            $table->integer('role_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('special_role_id')->references('id')->on('special_roles')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('special_role_roles');
    }
}
