<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeCoursesInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ge_courses_instructors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('instructor_id');
            $table->boolean('is_manager');
            $table->float('percent');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('course_id')->references('id')->on('ge_courses')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->on('auth_instructors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ge_courses_instructors');
    }
}
