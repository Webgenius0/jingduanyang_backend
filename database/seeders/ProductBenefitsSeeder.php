<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductBenefitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productBenefits = [
            [
                'product_id' => 1,
                'title' => 'Benefit 1 for Product 1',
            ],
            [
                'product_id' => 1,
                'title' => 'Benefit 2 for Product 1',
            ],
            [
                'product_id' => 2,
                'title' => 'Benefit 1 for Product 2',
            ],
            [
                'product_id' => 2,
                'title' => 'Benefit 2 for Product 2',
            ],
            [
                'product_id' => 3,
                'title' => 'Benefit 1 for Product 3',
            ],
            [
                'product_id' => 4,
                'title' => 'Benefit 1 for Product 4',
            ],
            [
                'product_id' => 5,
                'title' => 'Benefit 1 for Product 5',
            ],
            [
                'product_id' => 5,
                'title' => 'Benefit 2 for Product 5',
            ],
            [
                'product_id' => 6,
                'title' => 'Benefit 1 for Product 6',
            ],
            [
                'product_id' => 7,
                'title' => 'Benefit 1 for Product 7',
            ],
            [
                'product_id' => 6,
                'title' => 'Benefit 1 for Product 6',
            ],
            [
                'product_id' => 6,
                'title' => 'Benefit 2 for Product 6',
            ],
            [
                'product_id' => 7,
                'title' => 'Benefit 1 for Product 7',
            ],
            [
                'product_id' => 7,
                'title' => 'Benefit 2 for Product 7',
            ],
            [
                'product_id' => 8,
                'title' => 'Benefit 1 for Product 8',
            ],
            [
                'product_id' => 8,
                'title' => 'Benefit 2 for Product 8',
            ],
            [
                'product_id' => 9,
                'title' => 'Benefit 1 for Product 9',
            ],
            [
                'product_id' => 9,
                'title' => 'Benefit 2 for Product 9',
            ],
            [
                'product_id' => 10,
                'title' => 'Benefit 1 for Product 10',
            ],
            [
                'product_id' => 10,
                'title' => 'Benefit 2 for Product 10',
            ],
        ];

        DB::table('product_benefits')->insert($productBenefits);
    }
}
