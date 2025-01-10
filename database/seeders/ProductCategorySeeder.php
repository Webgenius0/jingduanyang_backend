<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => Str::slug('Electronics'), 'status' => 'active'],
            ['name' => 'Clothing', 'slug' => Str::slug('Clothing'), 'status' => 'active'],
            ['name' => 'Books', 'slug' => Str::slug('Books'), 'status' => 'active'],
            ['name' => 'Furniture', 'slug' => Str::slug('Furniture'), 'status' => 'inactive'],
            ['name' => 'Toys', 'slug' => Str::slug('Toys'), 'status' => 'active'],
        ];

        DB::table('product_categories')->insert($categories);
    }
}
