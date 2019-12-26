<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Discount;
use Faker\Generator as Faker;

$factory->define(Discount::class, function (Faker $faker) {
    $course = Course::orderByRaw('RAND()')->take(1)->first();
    return [
        'course_id' => $course->id,
        'discount_rate' => $faker->numberBetween(1, 100),
        'start_date' => $faker->dateTime,
        'finish_date' => $faker->dateTime,
    ];
});
