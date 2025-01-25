<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     public function run(): void
    {
        DB::table('orders')->insert([
            [
                'user_id' => 2,  // You should ensure the user_id exists in the users table
                'order_id' => 'ORD123456',
                'address' => '123 Main St, City, Country',
                'amount' => 200,
                'currency' => 'USD',
                'payment_method' => 'Credit Card',
                'status' => 'pending',
                'type' => 'medicine',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'order_id' => 'ORD123457',
                'address' => '456 Secondary St, City, Country',
                'amount' => 40,
                'currency' => 'USD',
                'payment_method' => 'PayPal',
                'status' => 'completed',
                'type' => 'appointment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'order_id' => 'ORD123458',
                'address' => '789 Tertiary St, City, Country',
                'amount' => 90.00,
                'currency' => 'USD',
                'payment_method' => 'Bank Transfer',
                'status' => 'cancelled',
                'type' => 'medicine',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
     
}
