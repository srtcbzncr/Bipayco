<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Discount;
use Faker\Generator as Faker;

$factory->define(Discount::class, function (Faker $faker) {
    $rand = rand(0, 100);
    $course = null;
    if ($rand > 50){
        $course = \App\Models\PrepareLessons\Course::orderByRaw('RAND()')->take(1)->first();
    }
    else{
        $course = \App\Models\GeneralEducation\Course::orderByRaw('RAND()')->take(1)->first();
    }
    return [
        'course_id' => $course->id,
        'course_type' => get_class($course),
        'discount_rate' => $faker->numberBetween(1, 100),
        'start_date' => $faker->dateTime,
        'finish_date' => $faker->dateTime,
    ];
});
