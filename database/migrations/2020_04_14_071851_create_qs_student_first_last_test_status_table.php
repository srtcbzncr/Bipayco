<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQsStudentFirstLastTestStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qs_student_first_last_test_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('studentId');
            $table->bigInteger('sectionId');
            $table->string('sectionType');
            $table->tinyInteger('testType'); // 0: ön test , 1: son test
            $table->tinyInteger('score');
            $table->tinyInteger('result');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qs_student_first_last_test_status');
    }
}
