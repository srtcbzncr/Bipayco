<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Base\City;
use App\Models\Base\Country;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {
    return [
        'country_id' => factory(Country::class),
        'code' => $faker->postcode,
        'name' => $faker->city,
    ];
});
