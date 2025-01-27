<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productImages = [
            [
                'product_id' => 1,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 1,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 2,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 2,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 3,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 3,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 4,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 4,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 5,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 5,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 6,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 6,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 7,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 7,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 8,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 8,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 9,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 9,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 10,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
            [
                'product_id' => 10,
                'images' => 'backend/images/placeholder/173675925417.png',
            ],
        ];

        DB::table('product_images')->insert($productImages);
    }
}
