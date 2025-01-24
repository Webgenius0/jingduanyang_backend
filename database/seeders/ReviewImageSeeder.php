<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('review_images')->insert([
            [
                'review_id' => 1,
                'image_url' => 'backend/images/placeholder/17367592541719693934.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => 1,
                'image_url' => 'backend/images/placeholder/17367592541719693934.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => 2,
                'image_url' => 'backend/images/placeholder/17367592541719693934.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => 2,
                'image_url' => 'backend/images/placeholder/17367592541719693934.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => 3,
                'image_url' => 'backend/images/placeholder/17367592541719693934.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
