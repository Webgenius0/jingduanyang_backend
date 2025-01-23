<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // $table->id();
    // $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
    // $table->string('order_id');
    // $table->decimal('amount', 10, 2);
    // $table->string('currency');
    // $table->string('payment_method');
    // $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
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
