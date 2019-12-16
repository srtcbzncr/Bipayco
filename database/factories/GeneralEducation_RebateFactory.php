<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\User;
use App\Models\GeneralEducation\Purchase;
use App\Models\GeneralEducation\Rebate;
use Faker\Generator as Faker;

$factory->define(Rebate::class, function (Faker $faker) {
    $purchase = Purchase::orderByRaw('RAND()')->take(1)->first();
    $user = User::orderByRaw('RAND()')->take(1)->first();
    return [
        'purchase_id' => $purchase->id,
        'user_id' => $user->id,
        'price' => $faker->numberBetween(1, 10000),
        'confirmation' => false,
    ];
});
