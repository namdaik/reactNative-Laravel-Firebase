<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\PlaceOfShipment;

$factory->define(PlaceOfShipment::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'name' => $faker->name,
        'phone' => randomPhoneNumber(),
        'address' => $faker->streetAddress,
        'province_id' => 1,
        'district_id' => 1,
        'ward_id' => 1,
    ];
});
