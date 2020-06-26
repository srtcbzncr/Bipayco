<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image');
            $table->string('name');
            $table->string('description');
            $table->float('price');
            $table->float('price_with_discount');
            $table->dateTime('datetime');
            $table->integer('max_participant');
            $table->string('attendee_pw');
            $table->string('moderator_pw');
            $table->boolean('record')->default(false);
            $table->integer('duration');
            $table->dateTime('completed_at')->nullable(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_courses');
    }
}
