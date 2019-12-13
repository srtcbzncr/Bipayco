<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ge_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title', 100);
            $table->string('content');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('lesson_id')->references('id')->on('ge_lessons')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('auth_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ge_questions');
    }
}
