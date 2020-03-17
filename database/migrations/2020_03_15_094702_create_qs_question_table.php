<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQsQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qs_question', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('text')->nullable(true);
            $table->string('imgUrl')->nullable(true);
            $table->tinyInteger('level');
            $table->string('type');
            $table->integer('crLessonId');
            $table->integer('crSubjectId');
            $table->integer('instructorId');
            $table->boolean('isConfirm');
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
        Schema::dropIfExists('qs_question');
    }
}
