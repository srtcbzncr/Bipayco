<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorsSocialMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bs_instructors_social_medias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('instructor_id')->unsigned();
            $table->bigInteger('social_media_id')->unsigned();
            $table->string('url', 300);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('instructor_id')->references('id')->on('auth_instructors')->onDelete('cascade');
            $table->foreign('social_media_id')->references('id')->on('bs_social_medias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bs_instructors_social_medias');
    }
}
