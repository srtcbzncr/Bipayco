<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('authority_id');
            $table->string('name', 100);
            $table->string('surname', 100);
            $table->string('reference_code');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('authority_id')->references('id')->on('auth_authorities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_admins');
    }
}
