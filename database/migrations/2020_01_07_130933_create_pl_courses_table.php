<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pl_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('grade_id');
            $table->string('image');
            $table->string('name', 100);
            $table->string('description', 500);
            $table->unsignedInteger('access_time')->default(12); // Month
            $table->boolean('certificate')->default(true);
            $table->unsignedInteger('long')->default(0); // Hour
            $table->float('price');
            $table->float('price_with_discount');
            $table->float('point')->default(0.0);
            $table->unsignedBigInteger('purchase_count')->default(0);
            $table->integer('score')->nullable(false)->default(50);
            $table->boolean('active')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('lesson_id')->references('id')->on('cr_lessons');
            $table->foreign('grade_id')->references('id')->on('cr_grades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pl_courses');
    }
}
