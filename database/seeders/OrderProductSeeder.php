<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */



    public function run(): void
    {
        DB::table('order_products')->insert([
            [
                'order_id' => 1,
                'product_id' => 1,
                'image_url' => 'backend/images/placeholder/17367592541719693934.png',
                'name' => 'Product 1',
                'quantity' => 4,
                'price' => 50, // Random price between 10 and 100
                'currency' => 'USD',
                'description' => 'Description for Product 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2,
                'product_id' => 2,
                'image_url' => 'backend/images/placeholder/17367592541719693934.png',
                'name' => 'Product 2',
                'quantity' => 2,
                'price' => 20, // Random price between 10 and 100
                'currency' => 'USD',
                'description' => 'Description for Product 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 3,
                'product_id' => 3,
                'image_url' => 'backend/images/placeholder/17367592541719693934.png',
                'name' => 'Rafi Ahmed',
                'quantity' => 1,
                'price' => 300, // Random price between 10 and 100
                'currency' => 'USD',
                'description' => 'I am a dedicated and experienced medicine specialist with a deep commitment to diagnosing, managing, and treating a wide range of medical conditions. My approach combines evidence-based practices with personalized care to ensure the best outcomes for my patients. I am passionate about staying updated with advancements in internal medicine and fostering a strong doctor-patient relationship built on trust, empathy, and open communication.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 4,
                'product_id' => 3,
                'image_url' => 'backend/images/placeholder/17367592541719693934.png',
                'name' => 'Rafi Ahmed',
                'quantity' => 1,
                'price' => 100, // Random price between 10 and 100
                'currency' => 'USD',
                'description' => 'I am a dedicated and experienced medicine specialist with a deep commitment to diagnosing, managing, and treating a wide range of medical conditions. My approach combines evidence-based practices with personalized care to ensure the best outcomes for my patients. I am passionate about staying updated with advancements in internal medicine and fostering a strong doctor-patient relationship built on trust, empathy, and open communication.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
