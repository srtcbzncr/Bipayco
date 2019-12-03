<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Student;
use Faker\Generator as Faker;
use App\Models\Base\School;
use App\Models\Auth\User;

$factory->define(Student::class, function (Faker $faker) {
    $rand_guardian = rand(0,100);
    return [
        'school_id' => factory(School::class),
        'guardian_id' => ($rand_guardian > 50) ? factory(User::class) : null,
    ];
});
