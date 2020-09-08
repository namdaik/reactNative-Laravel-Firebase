<?php

use App\Models\District;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Package;
use App\Models\PlaceOfShipment;
use App\Models\Province;
use App\Models\ShippingHistory;
use App\Models\TransactionPoint;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);
        Province::insert(config('data_provinces', []));
        District::insert(config('data_districts', []));
        Ward::insert(config('data_wards', []));
        $this->runByFactory();
        // $this->runByDataConfig();
    }
    public function runByFactory()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(QuickOrderSeeder::class);
    }
    public function runByDataConfig()
    {
        User::insert(config('data_user', []));
        PlaceOfShipment::insert(config('data_place_of_shipments', []));
        TransactionPoint::insert(config('data_transaction_points', []));
        Employee::insert(config('data_employees', []));
        Order::insert(config('data_orders', []));
        ShippingHistory::insert(config('data_shipping_histories', []));
        Package::insert(config('data_pakages', []));
    }
}
