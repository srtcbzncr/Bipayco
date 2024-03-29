<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\Section;
use App\Models\GeneralEducation\Course;
use Faker\Generator as Faker;

$factory->define(Section::class, function (Faker $faker) {
    $course = Course::orderByRaw('RAND()')->take(1)->first();
    $count = Section::where('course_id', $course->id)->get()->count();
    return [
        'course_id' => $course->id,
        'no' => $count+1,
        'name' => $faker->sentence(3),
    ];
});
