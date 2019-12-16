<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\Achievement;
use App\Models\GeneralEducation\Course;
use Faker\Generator as Faker;

$factory->define(Achievement::class, function (Faker $faker) {
    $course = Course::orderByRaw('RAND()')->take(1)->first();
    return [
        'course_id' => $course->id,
        'content' => $faker->sentence,
    ];
});
