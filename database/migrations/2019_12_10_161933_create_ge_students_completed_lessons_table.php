<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeStudentsCompletedLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ge_students_completed_lessons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('lesson_id');
            $table->boolean('is_completed');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('student_id')->references('id')->on('auth_students')->onDelete('cascade');
            $table->foreign('lesson_id')->references('id')->on('ge_lessons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ge_students_completed_lessons');
    }
}
