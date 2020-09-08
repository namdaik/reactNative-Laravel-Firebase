<?php

use App\Models\Order;
use App\Models\PlaceOfShipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $users = [
            [
                'name' => 'Vũ Thế Quân',
                'email' => 'quanvtph06842@fpt.edu.vn',
                'phone' => '0353003430',
                'gender' => 1,
                'address' => 'Số 99, Phường 01, Quận 3, Hồ Chí Minh',
            ],
            [
                'name' => 'Trần Thái',
                'email' => 'thaitph06858@fpt.edu.vn',
                'phone' => '0846900098',
                'gender' => 1,
                'address' => 'Số 94, Vạn Trạch, Bố Trạch, Quảng Bình',
            ],
            [
                'name' => 'Ngô Quang Trường',
                'email' => 'truongnqph06901@fpt.edu.vn',
                'phone' => '0984918726',
                'gender' => 1,
                'address' => 'Số 99, Bắc Sơn, Chương Mỹ, Hà Nội',
            ],
            [
                'name' => 'Đinh Tiến Chương',
                'email' => 'chuongdtph06876@fpt.edu.vn',
                'phone' => '0348921234',
                'gender' => 1,
                'address' => 'Số 98, Bắc Sơn, Chương Mỹ, Hà Nội',
            ],
        ];
        foreach ($users as $user) {
            $user = factory(User::class)->create($this->withBaseTime($user));
            $address = explode(', ', $user->address);
            $p = array_pop($address);
            for ($i = 0; $i < rand(3, 5); $i++) {

                $place = $this->withAddress($p, [
                    'user_id' => $user->id,
                    'created_at' => $faker->dateTimeBetween($user->created_at),
                    'updated_at' => $faker->dateTimeBetween($user->updated_at),
                ]);
                $place = factory(PlaceOfShipment::class)->create($place);
                factory(Order::class, rand(5, 20))->create([
                    'user_id' => $place->user_id,
                    'place_of_shipment_id' => $place->id,
                    'created_at' => $faker->dateTimeBetween($place->created_at),
                    'updated_at' => $faker->dateTimeBetween($place->updated_at),
                ]);
            }
        }
        factory(User::class, 50)->create($this->withBaseTime())->each(function ($user) use ($faker) {
            factory(PlaceOfShipment::class, rand(1, 3))
                ->create([
                    'user_id' => $user->id,
                    'created_at' => $faker->dateTimeBetween($user->created_at),
                    'updated_at' => $faker->dateTimeBetween($user->updated_at),
                ])
                ->each(function ($place)  use ($faker) {
                    factory(Order::class, rand(1, 10))->create([
                        'user_id' => $place->user_id,
                        'place_of_shipment_id' => $place->id,
                        'created_at' => $faker->dateTimeBetween($place->created_at),
                        'updated_at' => $faker->dateTimeBetween($place->updated_at),
                    ]);
                });
        });
    }

    public function withBaseTime($arr = [])
    {
        return array_merge($arr, [
            'created_at' => '2018-01-01 00:00:00',
            'updated_at' => '2018-01-01 00:00:00',
        ]);
    }

    public function withAddress($province_name, $arr = [])
    {
        return array_merge(
            collect(
                DB::table('provinces as p')->inRandomOrder()
                    ->join('districts as d', 'p.id', 'd.province_id')
                    ->join('wards as w', 'd.id', 'w.district_id')
                    ->where('p.name', $province_name)
                    ->first(['w.id as ward_id', 'd.id as district_id', 'p.id as province_id'])
            )->toArray(),
            $arr
        );
    }
}
