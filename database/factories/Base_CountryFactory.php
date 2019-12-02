<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Base\Country;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {
    return [
        'code' => $faker->countryCode,
        'name' => $faker->country,
    ];
});
