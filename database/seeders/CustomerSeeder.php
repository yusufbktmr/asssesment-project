<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $customers = [
            [
                'id' => 1,
                'name' => 'Türker Jöntürk',
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make($faker->password),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
            ],
            [
                'id' => 2,
                'name' => 'Kaptan Devopuz',
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make($faker->password),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
            ],
            [
                'id' => 3,
                'name' => 'İsa Sonuyumaz',
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make($faker->password),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
            ],
        ];

        DB::table('customers')->insert($customers);
    }
}
