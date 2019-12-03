<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Instructor;
use App\Models\Base\District;
use App\Models\Base\School;
use Faker\Generator as Faker;

$factory->define(Instructor::class, function (Faker $faker) {
    return [
        'school_id' => factory(School::class),
        'identification_number' => $faker->bothify('###########'),
        'title' => $faker->suffix,
        'bio' => $faker->text(500),
        'iban' => $faker->iban('TR'),
    ];
});
