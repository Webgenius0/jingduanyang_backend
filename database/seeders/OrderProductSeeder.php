<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
    */



    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            \App\Models\OrderPuduct::create([
                'order_id' => $faker->numberBetween(1, 100),
                'product_id' => $faker->numberBetween(1, 7),
                'image_url' => 'backend/images/placeholder/17367592541719693934.png',
                'name' => $faker->name,
                'quantity' => $faker->numberBetween(1, 10),
                'price' => $faker->randomFloat(2, 10, 100),
                'currency' => $faker->randomElement(['USD', 'EUR', 'GBP']),
                'description' => $faker->sentence,
            ]);
        }
    }
}
