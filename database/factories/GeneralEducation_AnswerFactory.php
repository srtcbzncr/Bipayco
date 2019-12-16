<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\Answer;
use App\Models\GeneralEducation\Question;
use App\Models\Auth\User;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    $question = Question::orderByRaw('RAND()')->take(1)->first();
    $user = User::orderByRaw('RAND()')->take(1)->first();
    return [
        'question_id' => $question->id,
        'user_id' => $user->id,
        'content' => $faker->sentence,
    ];
});
