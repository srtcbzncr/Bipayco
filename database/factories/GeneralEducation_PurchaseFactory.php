<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Purchase;
use Faker\Generator as Faker;

$factory->define(Purchase::class, function (Faker $faker) {
    $user = User::orderByRaw('RAND()')->take(1)->first();
    $student = Student::orderByRaw('RAND()')->take(1)->first();
    $course = Course::orderByRaw('RAND()')->take(1)->first();
    return [
        'user_id' => $user->id,
        'student_id' => $student->id,
        'course_id' => $course->id,
        'price' => $faker->numberBetween(1, 10000),
        'confirmation' => false,
    ];
});
