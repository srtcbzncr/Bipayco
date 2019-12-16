<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\Source;
use App\Models\GeneralEducation\Lesson;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

$factory->define(Source::class, function (Faker $faker) {
    $lesson = Lesson::orderByRaw('RAND()')->take(1)->first();
    $file = UploadedFile::fake()->image('deneme.jpg');
    $filePath = Storage::putFile('sources', $file);
    return [
        'lesson_id' => $lesson->id,
        'title' => $faker->sentence(3),
        'file_path' => $filePath,
    ];
});
