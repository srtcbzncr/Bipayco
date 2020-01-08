<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Curriculum\Grade;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

$factory->define(Grade::class, function (Faker $faker) {
    $file = UploadedFile::fake()->image('deneme.jpg');
    $symbolPath = Storage::url(Storage::putFile('public/symbols', $file));
    return [
        'name' => $faker->word,
        'symbol' => $symbolPath,
    ];
});
