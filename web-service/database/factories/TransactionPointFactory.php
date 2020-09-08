<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\TransactionPoint;

$factory->define(TransactionPoint::class, function (Faker $faker) {
    return [
        'province_id' => 1,
        'district_id' => 1,
        'ward_id' => 1,
        'address' => $faker->streetAddress,
        'name' => $faker->name,
    ];
});
