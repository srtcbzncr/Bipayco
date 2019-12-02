<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Instructor;
use App\Models\Base\District;
use App\Models\Base\School;
use Faker\Generator as Faker;

$factory->define(Instructor::class, function (Faker $faker) {
    return [
        'district_id' => factory(District::class),
        'school_id' => factory(School::class),
        'identification_number' => $faker->bothify('###########'),
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'title' => $faker->suffix,
        'bio' => $faker->text(500),
        'phone_number' => $faker->e164PhoneNumber,
        'avatar' => $faker->image(),
        'iban' => $faker->iban('TR'),
        'reference_code' => $faker->bothify('**********'),
    ];
});
