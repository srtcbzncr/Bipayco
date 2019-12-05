<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('guardian_id')->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', '100');
            $table->string('username', 50);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number', 20);
            $table->string('password');
            $table->string('avatar', 500);
            $table->boolean('active')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('district_id')->references('id')->on('bs_districts');
            $table->foreign('student_id')->references('id')->on('auth_students')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->on('auth_instructors')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('auth_managers')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('auth_admins')->onDelete('cascade');
            $table->foreign('guardian_id')->references('id')->on('auth_guardians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_users');
    }
}
