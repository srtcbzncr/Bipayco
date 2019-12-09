<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Admin;
use Faker\Generator as Faker;
use App\Models\Auth\Authority;
use App\Models\Auth\User;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'authority_id' => factory(Authority::class),
        'user_id' => factory(User::class),
        'reference_code' => uniqid('ad'.random_int(100,999), false),
    ];
});
