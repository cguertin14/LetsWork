<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('description');
            $table->string('telephone')->unique();
            $table->string('email')->unique();
            $table->string('ville');
            $table->string('adresse');
            $table->string('zipcode');
            $table->string('pays');
            $table->string('slug');
            $table->binary('photo')->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('company_type_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_type_id')->references('id')->on('company_types')->onDelete('cascade');
            $table->unique(["id","name"]);
        });

        DB::statement('alter table companies MODIFY photo LONGBLOB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('companies');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
