<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Order;
use App\Models\Ward;

$factory->define(Order::class, function (Faker $faker) {
    $ward_ids = Ward::pluck('id')->toArray();
    return [
        'id' => Str::random(6),
        'place_of_shipment_id' => 1,
        'user_id' => 1,
        'transaction_point_id' => null,
        'receivers' => json_encode([
            'name' => $faker->name,
            'phone' => randomPhoneNumber(),
            'address' => $faker->streetAddress,
            'ward' => $faker->randomElement($ward_ids),
        ]),
        'employee_id' => null,
        'price' => $faker->numberBetween(16000, 999999),
        'parcel_length' => $faker->numberBetween(1, 80),
        'parcel_width' => $faker->numberBetween(1, 80),
        'parcel_height' => $faker->numberBetween(1, 80),
        'parcel_weight' => $faker->numberBetween(500, 20000),
        'parcel_description' => $faker->realText(100),
        'note' => $faker->sentence(3),
        'status' => 0,
        'is_paid' => $faker->boolean(),
        'is_return' => $faker->boolean(10),
    ];
});
