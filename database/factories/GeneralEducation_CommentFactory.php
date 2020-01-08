<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\User;
use App\Models\GeneralEducation\Comment;
use App\Models\GeneralEducation\Course;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $rand = rand(0, 100);
    $course = null;
    if ($rand > 50){
        $course = \App\Models\PrepareLessons\Course::orderByRaw('RAND()')->take(1)->first();
    }
    else{
        $course = \App\Models\GeneralEducation\Course::orderByRaw('RAND()')->take(1)->first();
    }
    $user = User::orderByRaw('RAND()')->take(1)->first();
    return [
        'course_id' => $course->id,
        'course_type' => get_class($course),
        'user_id' => $user->id,
        'content' => $faker->sentence,
        'point' => $faker->numberBetween(0, 5),
    ];
});
