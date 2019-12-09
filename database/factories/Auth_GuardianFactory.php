<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Auth\Guardian;
use App\Models\Auth\User;

$factory->define(Guardian::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'reference_code' => uniqid('gu'.random_int(100,999), false),
    ];
});
