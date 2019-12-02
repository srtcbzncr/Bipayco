<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Base\SocialMedia;
use Faker\Generator as Faker;

$factory->define(SocialMedia::class, function (Faker $faker) {
    return [
        'symbol' => $faker->image(),
        'name' => $faker->company,
    ];
});
