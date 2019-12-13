<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeRebatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ge_rebates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('purchase_id');
            $table->float('price');
            $table->boolean('confirmation');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('auth_users');
            $table->foreign('purchase_id')->references('id')->on('ge_purchases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ge_rebates');
    }
}
