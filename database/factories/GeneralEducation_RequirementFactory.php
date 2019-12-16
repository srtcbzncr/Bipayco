<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Requirement;
use Faker\Generator as Faker;

$factory->define(Requirement::class, function (Faker $faker) {
    $course = Course::orderByRaw('RAND()')->take(1)->first();
    return [
        'course_id' => $course->id,
        'content' => $faker->sentence,
    ];
});
