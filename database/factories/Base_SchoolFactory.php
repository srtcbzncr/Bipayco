<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Base\School;
use App\Models\Base\District;
use Faker\Generator as Faker;

$factory->define(School::class, function (Faker $faker) {
    return [
        'district_id' => factory(District::class),
        'name' => $faker->company,
        'address' => $faker->address,
        'manager_reference_code' => uniqid('scmn'.random_int(100,999), false),
        'student_reference_code' => uniqid('scmn'.random_int(100,999), false),
        'instructor_reference_code' => uniqid('scmn'.random_int(100,999), false),
    ];
});
