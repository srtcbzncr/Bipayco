<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Instructor;
use App\Models\Base\District;
use App\Models\Base\School;
use Faker\Generator as Faker;

$factory->define(Instructor::class, function (Faker $faker) {
    $rand_school = rand(0,100);
    return [
        'school_id' => ($rand_school > 50) ? factory(School::class) : null,
        'identification_number' => $faker->bothify('###########'),
        'title' => $faker->suffix,
        'bio' => $faker->text(500),
        'iban' => $faker->iban('TR'),
    ];
});
