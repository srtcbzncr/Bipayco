<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Base\District;
use App\Models\Base\City;
use Faker\Generator as Faker;

$factory->define(District::class, function (Faker $faker) {
    return [
        'city_id' => factory(City::class),
        'name' => $faker->city,
    ];
});
