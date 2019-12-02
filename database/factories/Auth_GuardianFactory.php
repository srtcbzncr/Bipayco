<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Guardian;
use App\Models\Base\District;
use Faker\Generator as Faker;

$factory->define(Guardian::class, function (Faker $faker) {
    return [
        'district_id' => factory(District::class),
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'phone_number' => $faker->e164PhoneNumber,
    ];
});
