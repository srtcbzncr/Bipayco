<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Authority;
use Faker\Generator as Faker;

$factory->define(Authority::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
