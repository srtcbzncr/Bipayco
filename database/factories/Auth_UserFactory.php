<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Auth\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Base\District;
use App\Models\Auth\Student;
use App\Models\Auth\Instructor;
use App\Models\Auth\Manager;
use App\Models\Auth\Admin;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $rand_instructor = rand(0,100);
    $rand_manager = rand(0,100);
    $rand_admin = rand(0,100);

    return [
        'district_id' => factory(District::class),
        'student_id' => factory(Student::class),
        'instructor_id' => ($rand_instructor > 50) ? factory(Instructor::class) : null,
        'manager_id' => ($rand_manager > 70) ? factory(Manager::class) : null,
        'admin_id' => ($rand_admin > 80) ? factory(Manager::class) : null,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'phone_number' => $faker->e164PhoneNumber,
        'password' => Hash::make('123456'),
        'avatar' => $faker->image(),
        'remember_token' => Str::random(10),
    ];
});
