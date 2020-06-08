<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIyzicoBasketItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iyzico_basket_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('iyzico_basket_id')->nullable(true);
            $table->string('item_id')->nullable(true);
            $table->string('course_type')->nullable(true);
            $table->integer('course_id')->nullable(true);
            $table->decimal('price')->nullable(true);
            $table->string('payment_transaction_id')->nullable(true);
            $table->integer('transaction_status')->nullable(true);
            $table->boolean('confirmation')->nullable(true);
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
        Schema::dropIfExists('iyzico_basket_items');
    }
}
