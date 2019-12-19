<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Category;
use App\Models\GeneralEducation\SubCategory;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

$factory->define(Course::class, function (Faker $faker) {
    $category = Category::orderByRaw('RAND()')->take(1)->first();
    $subCategory = SubCategory::orderByRaw('RAND()')->take(1)->first();
    $file = UploadedFile::fake()->image('deneme.jpg');
    $imagePath = Storage::url(Storage::putFile('public/images', $file));
    return [
        'category_id' => $category->id,
        'sub_category_id' => $subCategory->id,
        'image' => $imagePath,
        'name' => $faker->sentence(3),
        'description' => $faker->sentence(10),
        'price' => 100,
    ];
});
