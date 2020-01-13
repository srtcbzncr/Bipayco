<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_instructors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('school_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('reference_instructor_id')->nullable();
            $table->string('identification_number', 11);
            $table->string('title', 200);
            $table->string('bio', 500);
            $table->string('iban', 50);
            $table->string('reference_code', 18);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('school_id')->references('id')->on('bs_schools');
            $table->foreign('user_id')->references('id')->on('auth_users');
            $table->foreign('reference_instructor_id')->references('id')->on('auth_instructors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_instructors');
    }
}
