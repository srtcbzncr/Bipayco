<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Base\SocialMedia;
use Illuminate\Http\UploadedFile;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;

$factory->define(SocialMedia::class, function (Faker $faker) {
    $file = UploadedFile::fake()->image('deneme.jpg');
    $symbolPath = Storage::url(Storage::putFile('public/symbols', $file));
    return [
        'symbol' => $symbolPath,
        'name' => $faker->company,
    ];
});
