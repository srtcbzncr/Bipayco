<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\SubCategory;
use App\Models\GeneralEducation\Category;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

$factory->define(SubCategory::class, function (Faker $faker) {
    $file = UploadedFile::fake()->image('deneme.jpg');
    $symbolPath = Storage::url(Storage::putFile('public/symbols', $file));
    $category = Category::orderByRaw('RAND()')->take(1)->first();
    return [
        'category_id' => $category->id,
        'name' => $faker->sentence(3),
        'description' => $faker->sentence,
        'color' => $faker->hexColor,
        'symbol' => $symbolPath,
    ];
});
