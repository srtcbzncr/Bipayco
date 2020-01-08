<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\User;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Favorite;
use Faker\Generator as Faker;

$factory->define(Favorite::class, function (Faker $faker) {
    $user = User::orderByRaw('RAND()')->take(1)->first();
    $rand = rand(0, 100);
    $course = null;
    if ($rand > 50){
        $course = \App\Models\PrepareLessons\Course::orderByRaw('RAND()')->take(1)->first();
    }
    else{
        $course = \App\Models\GeneralEducation\Course::orderByRaw('RAND()')->take(1)->first();
    }
    return [
        'user_id' => $user->id,
        'course_id' => $course->id,
        'course_type' => get_class($course),
    ];
});
