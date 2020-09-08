<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => randomPhoneNumber(),
        'avatar' => $faker->imageUrl(500, 500, 'people'),
        'password' => bcrypt('password'),
        'gender' => $faker->numberBetween(1, 2),
        'address' => randAddressByProvinceId(),
        'verified_at' => '2018-01-01 00:00:00',
        'remember_token' => Str::random(10),
    ];
});

function randAddressByProvinceId($p_id = null)
{
    $address = DB::table('provinces as p')->inRandomOrder()
        ->join('districts as d', 'p.id', 'd.province_id')
        ->join('wards as w', 'd.id', 'w.district_id')
        ->where('p.id', $p_id?:rand(1, 63))
        ->first(['w.name as ward', 'd.name as district', 'p.name as province']);
    $houseNumber = rand(1, 300);
    return "Số $houseNumber, $address->ward, $address->district, $address->province";
}

function randomPhoneNumber()
{
    $items = ['0912', '0983', '0864', '0123', '0356', '0868', '0818', '0975', '0909', '0908', '0966'];
    $sequence = $items[array_rand($items)];
    for ($i = 0; $i < 6; ++$i) {
        $sequence .= rand(0, 9);
    }
    return $sequence;
}
