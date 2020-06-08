<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIyzicoBasketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iyzico_basket', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('price')->nullable(true);
            $table->string('token')->nullable(true);
            $table->string('status')->nullable(true);
            $table->string('payment_status')->nullable(true);
            $table->string('error_message')->nullable(true);
            $table->string('payment_id')->nullable(true);
            $table->integer('fraud_status')->nullable(true);
            $table->decimal('iyzico_comission_fee')->nullable(true);
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
        Schema::dropIfExists('iyzico_basket');
    }
}
