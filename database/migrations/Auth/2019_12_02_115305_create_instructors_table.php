<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorsTable extends Migration
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
            $table->integer('district_id');
            $table->integer('school_id')->nullable();
            $table->string('identification_number', 11);
            $table->string('name', 100);
            $table->string('surname', 100);
            $table->string('title', 200);
            $table->string('bio', 500);
            $table->string('phone_number', 20);
            $table->string('avatar', 500);
            $table->string('iban', 50);
            $table->string('reference_code', 50);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('district_id')->references('id')->on('bs_districts');
            $table->foreign('school_id')->references('id')->on('bs_schools');
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
