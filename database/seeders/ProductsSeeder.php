<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'product_category_id' => 1,
                'title' => 'Product 1',
                'slug' => Str::slug('Product 1'),
                'price' => '100',
                'discount_price' => '90',
                'quantity' => '10',
                'about' => 'About Product 1',
                'description' => 'Description of Product 1',
                'status' => 'active',
            ],
            [
                'product_category_id' => 1,
                'title' => 'Product 2',
                'slug' => Str::slug('Product 2'),
                'price' => '200',
                'discount_price' => '180',
                'quantity' => '20',
                'about' => 'About Product 2',
                'description' => 'Description of Product 2',
                'status' => 'active',
            ],
            [
                'product_category_id' => 2,
                'title' => 'Product 3',
                'slug' => Str::slug('Product 3'),
                'price' => '150',
                'discount_price' => '120',
                'quantity' => '15',
                'about' => 'About Product 3',
                'description' => 'Description of Product 3',
                'status' => 'inactive',
            ],
            [
                'product_category_id' => 2,
                'title' => 'Product 4',
                'slug' => Str::slug('Product 4'),
                'price' => '250',
                'discount_price' => '230',
                'quantity' => '12',
                'about' => 'About Product 4',
                'description' => 'Description of Product 4',
                'status' => 'active',
            ],
            [
                'product_category_id' => 3,
                'title' => 'Product 5',
                'slug' => Str::slug('Product 5'),
                'price' => '300',
                'discount_price' => '270',
                'quantity' => '8',
                'about' => 'About Product 5',
                'description' => 'Description of Product 5',
                'status' => 'active',
            ],
            [
                'product_category_id' => 3,
                'title' => 'Product 6',
                'slug' => Str::slug('Product 6'),
                'price' => '400',
                'discount_price' => null,
                'quantity' => '5',
                'about' => 'About Product 6',
                'description' => 'Description of Product 6',
                'status' => 'inactive',
            ],
            [
                'product_category_id' => 4,
                'title' => 'Product 7',
                'slug' => Str::slug('Product 7'),
                'price' => '500',
                'discount_price' => '450',
                'quantity' => '7',
                'about' => 'About Product 7',
                'description' => 'Description of Product 7',
                'status' => 'active',
            ],
            [
                'product_category_id' => 4,
                'title' => 'Product 8',
                'slug' => Str::slug('Product 8'),
                'price' => '600',
                'discount_price' => '550',
                'quantity' => '11',
                'about' => 'About Product 8',
                'description' => 'Description of Product 8',
                'status' => 'active',
            ],
            [
                'product_category_id' => 5,
                'title' => 'Product 9',
                'slug' => Str::slug('Product 9'),
                'price' => '700',
                'discount_price' => null,
                'quantity' => '9',
                'about' => 'About Product 9',
                'description' => 'Description of Product 9',
                'status' => 'inactive',
            ],
            [
                'product_category_id' => 5,
                'title' => 'Product 10',
                'slug' => Str::slug('Product 10'),
                'price' => '800',
                'discount_price' => '750',
                'quantity' => '6',
                'about' => 'About Product 10',
                'description' => 'Description of Product 10',
                'status' => 'active',
            ],
        ];

        DB::table('products')->insert($products);
    }
}
