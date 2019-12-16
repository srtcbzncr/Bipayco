<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Student;
use Faker\Generator as Faker;
use App\Models\Base\School;
use App\Models\Auth\Guardian;
use App\Models\Auth\User;

$factory->define(Student::class, function (Faker $faker) {
    $rand_guardian = rand(0,100);
    $rand_school = rand(0,100);
    $guardian = Guardian::orderByRaw('RAND()')->take(1)->first();
    $school = School::orderByRaw('RAND()')->take(1)->first();
    return [
        'user_id' => factory(User::class),
        'school_id' => ($rand_school > 60 ) ? factory(School::class) : null,
        'guardian_id' => ($rand_guardian > 50) ? $guardian->id : null,
        'reference_code' => uniqid('st'.random_int(100,999), false),
    ];
});
