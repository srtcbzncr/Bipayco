<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQsStudentFirstLastTestAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qs_student_first_last_test_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('studentId');
            $table->bigInteger('questionId');
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
        Schema::dropIfExists('qs_student_first_last_test_answers');
    }
}
