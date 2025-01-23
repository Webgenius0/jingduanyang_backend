<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            \App\Models\Order::create([
                'user_id' => 2,
                'order_id' => $faker->uuid,
                'amount' => $faker->randomFloat(2, 10, 100),
                'currency' => $faker->randomElement(['USD', 'EUR', 'GBP']),
                'payment_method' => 'paypal',
                'status' => $faker->randomElement(['pending', 'completed', 'cancelled']),
            ]);
        }
    }
}
