<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\User;
use App\Models\GeneralEducation\Comment;
use App\Models\GeneralEducation\Course;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $course = Course::orderByRaw('RAND()')->take(1)->first();
    $user = User::orderByRaw('RAND()')->take(1)->first();
    return [
        'course_id' => $course->id,
        'user_id' => $user->id,
        'content' => $faker->sentence,
        'point' => $faker->numberBetween(0, 5),
    ];
});
