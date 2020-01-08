<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Curriculum\Grade;
use App\Models\Curriculum\Lesson;
use App\Models\PrepareLessons\Course;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

$factory->define(Course::class, function (Faker $faker) {
    $lesson = Lesson::orderByRaw('RAND()')->take(1)->first();
    $grade = Grade::orderByRaw('RAND()')->take(1)->first();
    $file = UploadedFile::fake()->image('deneme.jpg');
    $imagePath = Storage::url(Storage::putFile('public/images', $file));
    return [
        'lesson_id' => $lesson->id,
        'grade_id' => $grade->id,
        'image' => $imagePath,
        'name' => $faker->sentence(3),
        'description' => $faker->sentence(10),
        'price' => 100,
        'price_with_discount' => 100,
        'active' => true,
    ];
});
