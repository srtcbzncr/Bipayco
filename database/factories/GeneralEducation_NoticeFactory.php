<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Notice;
use Faker\Generator as Faker;

$factory->define(Notice::class, function (Faker $faker) {
    $course = Course::orderByRaw('RAND()')->take(1)->first();
    return [
        'course_id' => $course->id,
        'title' => $faker->sentence(3),
        'message' => $faker->sentence,
    ];
});
