<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Instructor;
use App\Models\Base\School;
use Faker\Generator as Faker;
use App\Models\Auth\User;

$factory->define(Instructor::class, function (Faker $faker) {
    $rand_school = rand(0,100);
    return [
        'user_id' => factory(User::class),
        'school_id' => ($rand_school > 50) ? factory(School::class) : null,
        'identification_number' => $faker->bothify('###########'),
        'title' => $faker->suffix,
        'bio' => $faker->text(500),
        'iban' => $faker->iban('TR'),
        'reference_code' => uniqid('in'.random_int(100,999), false),
    ];
});
