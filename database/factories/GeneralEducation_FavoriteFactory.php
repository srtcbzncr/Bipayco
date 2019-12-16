<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\User;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Favorite;
use Faker\Generator as Faker;

$factory->define(Favorite::class, function (Faker $faker) {
    $user = User::orderByRaw('RAND()')->take(1)->first();
    $course = Course::orderByRaw('RAND()')->take(1)->first();
    return [
        'user_id' => $user->id,
        'course_id' => $course->id,
    ];
});
