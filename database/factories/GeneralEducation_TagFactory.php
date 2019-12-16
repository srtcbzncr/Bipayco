<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    $course = Course::orderByRaw('RAND()')->take(1)->first();
    return [
        'course_id' => $course->id,
        'tag' => $faker->word,
    ];
});
