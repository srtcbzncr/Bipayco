<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Admin;
use Faker\Generator as Faker;
use App\Models\Auth\Authority;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'authority_id' => factory(Authority::class),
        'reference_code' => $faker->bothify('**********'),
    ];
});
