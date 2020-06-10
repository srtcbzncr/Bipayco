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
            $table->unsignedBigInteger('payment_id')->nullable(true);
            $table->string('payment_transaction_id')->nullable(true);
            $table->string('message'); // kullanıcı iade sebebi
            $table->tinyInteger('rebate_status'); // iade durumu: -1:red, 0: bekliyor, 1: onaylandı
            $table->float('price');
            $table->boolean('confirmation')->default(false);
            $table->dateTime('confirmation_date')->nullable();
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
