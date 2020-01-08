<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\Source;
use App\Models\GeneralEducation\Lesson;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

$factory->define(Source::class, function (Faker $faker) {
    $rand = rand(0, 100);
    $lesson = null;
    if ($rand > 50){
        $lesson = \App\Models\PrepareLessons\Lesson::orderByRaw('RAND()')->take(1)->first();
    }
    else{
        $lesson = \App\Models\GeneralEducation\Lesson::orderByRaw('RAND()')->take(1)->first();
    }
    $file = UploadedFile::fake()->image('deneme.jpg');
    $filePath = Storage::putFile('sources', $file);
    return [
        'lesson_id' => $lesson->id,
        'lesson_type' => get_class($lesson),
        'title' => $faker->sentence(3),
        'file_path' => $filePath,
    ];
});
