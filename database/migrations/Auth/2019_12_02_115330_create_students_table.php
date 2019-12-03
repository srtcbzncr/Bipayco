<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('district_id')->unsigned();
            $table->bigInteger('school_id')->unsigned()->nullable();
            $table->bigInteger('guardian_id')->unsigned()->nullable();
            $table->string('name', 100);
            $table->string('surname', 100);
            $table->String('phone_number', 20);
            $table->string('avatar', 500);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('district_id')->references('id')->on('bs_districts');
            $table->foreign('school_id')->references('id')->on('bs_schools');
            $table->foreign('guardian_id')->references('id')->on('auth_guardians');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_students');
    }
}
