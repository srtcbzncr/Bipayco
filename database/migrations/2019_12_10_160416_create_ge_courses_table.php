<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ge_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->string('image');
            $table->string('name', 100);
            $table->string('description', 1500);
            $table->unsignedInteger('access_time')->default(12); // Month
            $table->boolean('certificate')->default(true);
            $table->unsignedInteger('long')->default(0); // Hour
            $table->float('price');
            $table->float('price_with_discount');
            $table->float('point')->default(0.0);
            $table->unsignedBigInteger('purchase_count')->default(0);
            $table->boolean('active')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('ge_categories');
            $table->foreign('sub_category_id')->references('id')->on('ge_sub_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ge_courses');
    }
}
