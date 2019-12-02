<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Student;
use Faker\Generator as Faker;
use App\Models\Base\District;
use App\Models\Base\School;
use App\Models\Auth\Guardian;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'district_id' => factory(District::class),
        'school_id' => factory(School::class),
        'guardian_id' => factory(Guardian::class),
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'phone_number' => $faker->e164PhoneNumber,
        'avatar' => $faker->image(),
    ];
});
