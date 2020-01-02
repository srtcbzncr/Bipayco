<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\Category;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

$factory->define(Category::class, function (Faker $faker) {
    $file = UploadedFile::fake()->image('deneme.jpg');
    $symbolPath = Storage::url(Storage::putFile('public/symbols', $file));
    $imagePath = Storage::url(Storage::putFile('public/images', $file));
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'color' => $faker->hexColor,
        'symbol' => $symbolPath,
        'image' => $imagePath,
    ];
});
