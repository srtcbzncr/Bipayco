<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ge_purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->float('price');
            $table->boolean('confirmation');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('auth_users');
            $table->foreign('student_id')->references('id')->on('auth_students');
            $table->foreign('course_id')->references('id')->on('ge_courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ge_purchases');
    }
}
