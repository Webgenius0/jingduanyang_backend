<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'user_id' => 2,
                'product_id' => 1,
                'rating' => 5,
                'comment' => 'Excellent product! Highly recommended.',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'product_id' => 1,
                'rating' => 4,
                'comment' => 'Good quality but a bit expensive.',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'product_id' => 2,
                'rating' => 4,
                'comment' => 'Good quality but a bit expensive.',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'product_id' => 3,
                'rating' => 3,
                'comment' => 'Average product. Could be improved.',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
