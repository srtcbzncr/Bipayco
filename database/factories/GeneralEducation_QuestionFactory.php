<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\User;
use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    $lesson = Lesson::orderByRaw('RAND()')->take(1)->first();
    $user = User::orderByRaw('RAND()')->take(1)->first();
    return [
        'lesson_id' => $lesson->id,
        'user_id' => $user->id,
        'title' => $faker->sentence(3),
        'content' => $faker->sentence,
    ];
});
