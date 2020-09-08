<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Package;
use App\Models\TransactionPoint;
use App\Models\Order;
use App\Models\Employee;

$factory->define(Package::class, function (Faker $faker) {
    static $index = 0;
    $count = $faker->numberBetween(2,10);
    $transaction_point_ids = TransactionPoint::pluck('id')->toArray();
    $order_ids = Order::skip($index)->take($count)->pluck('id')->toArray();
    $index+=$count;
    $employees_ids = Employee::pluck('id')->toArray();
    return [
        'order_ids' => json_encode($order_ids),
        'transaction_point_id' => $faker->randomElement($transaction_point_ids),
        'next_transaction_point_id' => $faker->randomElement($transaction_point_ids),
        'employee_id' => $faker->randomElement($employees_ids),
    ];
});

