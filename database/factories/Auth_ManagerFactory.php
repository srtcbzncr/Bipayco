<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Manager;
use App\Models\Base\District;
use App\Models\Base\School;
use Faker\Generator as Faker;
use App\Models\Auth\User;

$factory->define(Manager::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'school_id' => factory(School::class),
        'identification_number' => $faker->bothify('###########'),
        'reference_code' => uniqid('mn'.random_int(100,999), false),
    ];
});
