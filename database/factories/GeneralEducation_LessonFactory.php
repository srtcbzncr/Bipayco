<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\Section;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

$factory->define(Lesson::class, function (Faker $faker) {
    $section = Section::orderByRaw('RAND()')->take(1)->first();
    $count = Lesson::where('section_id', $section->id)->get()->count();
    $file = UploadedFile::fake()->image('deneme.jpg');
    $imagePath = Storage::putFile('lessons', $file);
    return [
        'section_id' => $section->id,
        'is_video' => false,
        'no' => $count+1,
        'name' => $faker->sentence(3),
        'long' => '01:10:43',
        'preview' => false,
        'file_path' => $imagePath,
    ];
});
