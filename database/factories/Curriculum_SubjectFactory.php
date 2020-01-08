<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Curriculum\Subject;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

$factory->define(Subject::class, function (Faker $faker) {
    $lesson = \App\Models\Curriculum\Lesson::orderByRaw('RAND()')->take(1)->first();
    $file = UploadedFile::fake()->image('deneme.jpg');
    $symbolPath = Storage::url(Storage::putFile('public/symbols', $file));
    return [
        'lesson_id' => $lesson->id,
        'name' => $faker->word,
        'symbol' => $symbolPath,
    ];
});
