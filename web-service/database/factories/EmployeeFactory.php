<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Employee;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'transaction_point_id' => null,
        'name' => $faker->name,
        'phone' => randomPhoneNumber(),
        'avatar' => $faker->imageUrl(500, 500, 'people'),
        'gender' => $faker->numberBetween(1, 2),
        'address' => $faker->address,
        'password' => bcrypt('password'),
        'profile_number' => Str::random(6),
    ];
});
