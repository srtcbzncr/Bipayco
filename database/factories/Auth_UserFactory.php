<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Auth\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
    $profiles = [
        App\Models\Auth\Student::class,
        App\Models\Auth\Guardian::class,
        App\Models\Auth\Instructor::class,
        App\Models\Auth\Manager::class,
        App\Models\Auth\Admin::class,
    ];
    $profile_type = $faker->randomElement($profiles);
    $profile = factory($profile_type)->create();
    return [
        'name' => $faker->name,
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('123456'),
        'remember_token' => Str::random(10),
        'profile_type' => $profile_type,
        'profile_id' => $profile->id,
    ];
});
