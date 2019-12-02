<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Manager;
use App\Models\Base\District;
use App\Models\Base\School;
use Faker\Generator as Faker;

$factory->define(Manager::class, function (Faker $faker) {
    return [
        'district_id' => factory(District::class),
        'school_id' => factory(School::class),
        'identification_number' => $faker->bothify('###########'),
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'phone_number' => $faker->e164PhoneNumber,
        'reference_code' => $faker->bothify('**********'),
    ];
});
