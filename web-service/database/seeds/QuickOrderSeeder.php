<?php

use App\Models\Employee;
use App\Models\Order;
use App\Models\TransactionPoint;
use Illuminate\Database\Seeder;

class QuickOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        factory(Employee::class)->create($this->withBaseTime(['email' => 'admin@gmail.com',]))->assignRole('admin');
        $transactionPoints = [
            [
                'province_id' => 1,
                'district_id' => 195,
                'ward_id' => 3402,
                'address' => 'Số 85',
                'name' => 'Quick Order 001 hn',
            ],
            [
                'province_id' => 2,
                'district_id' => 25,
                'ward_id' => 403,
                'address' => 'Số 17',
                'name' => 'Quick Order 002 hg',
            ],
            [
                'province_id' => 29,
                'district_id' => 339,
                'ward_id' => 6557,
                'address' => 'Số 465',
                'name' => 'Quick Order 003 qb',
            ],
            [
                'province_id' => 32,
                'district_id' => 365,
                'ward_id' => 6898,
                'address' => 'Số 22',
                'name' => 'Quick Order 004 dn',
            ],
            [
                'province_id' => 50,
                'district_id' => 566,
                'ward_id' => 9361,
                'address' => 'Số 50',
                'name' => 'Quick Order 005 hcm',
            ],
            [
                'province_id' => 59,
                'district_id' => 670,
                'ward_id' => 10728,
                'address' => 'Số 96',
                'name' => 'Quick Order 006 ct',
            ]
        ];
        foreach ($transactionPoints as $tran) {
            $tran = factory(TransactionPoint::class)->create($this->withBaseTime($tran));
            $name = explode(' ', $tran->name);
            $tranName = array_pop($name);
            factory(Employee::class)
                ->create($this->withBaseTime(['address' => randAddressByProvinceId($tran->province_id), 'transaction_point_id' => $tran->id, 'email' => "$tranName.quanly@gmail.com",]))
                ->assignRole('manager');

            for ($i = 1; $i <= rand(3, 5); $i++) {
                $receptionist =  factory(Employee::class)
                    ->create($this->withBaseTime(['address' => randAddressByProvinceId($tran->province_id), 'transaction_point_id' => $tran->id, 'email' => "$tranName.nhanvien$i@gmail.com"]))
                    ->assignRole('receptionist');
                $order = Order::inRandomOrder()->where('status', 0)->first();
                $order->status = 1;
                $order->transaction_point_id = $tran->id;
                $order->employee_id = $receptionist->id;
                $order->save();
            }
        }
    }
    public function withBaseTime($arr = [])
    {
        return array_merge($arr, [
            'created_at' => '2018-01-01 00:00:00',
            'updated_at' => '2018-01-01 00:00:00',
        ]);
    }
    function randAddressByProvinceId($p_id = null)
    {
        $address = DB::table('provinces as p')->inRandomOrder()
            ->join('districts as d', 'p.id', 'd.province_id')
            ->join('wards as w', 'd.id', 'w.district_id')
            ->where('p.id', $p_id ?: rand(1, 63))
            ->first(['w.name as ward', 'd.name as district', 'p.name as province']);
        $houseNumber = rand(1, 300);
        return "Số $houseNumber, $address->ward, $address->district, $address->province";
    }
}
