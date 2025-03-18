<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 500; $i++) {
            DB::table('orders')->insert([
                'name' => $faker->word, 
                'client_id' => $faker->numberBetween(1, 100),
                'driver_id' => $faker->numberBetween(1, 100),
                'vehicle_id' => $faker->numberBetween(1, 100),
                'owner_id' => $faker->numberBetween(1, 100),
                'loadType_id' => $faker->numberBetween(1, 10),
                'loading_place' => $faker->city,
                'destination' => $faker->city,
                'quintal' => $faker->numberBetween(10, 500),
                'given_tarrif' => $faker->randomFloat(2, 500, 5000),
                'sub_tarrif' => $faker->randomFloat(2, 100, 2000),
                'arrival_date' => $faker->date(),
                'loading_date' => $faker->date(),
                'condition' => $faker->randomElement(['Loaded', 'OffLodeded']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
