<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('blogs')->insert([
            [
                'blog_category_id' => 1,
                'title' => 'Latest Technology Trends in 2025',
                'slug' => 'latest-technology-trends-2025',
                'image' => 'backend/images/placeholder/blog-img-1.png',
                'description' => 'Explore the top technology trends that are shaping the future of industries worldwide.',
                'sub_description' => 'Technology is evolving at a rapid pace, and staying updated is essential.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_category_id' => 2,
                'title' => 'Top 10 Health Tips for a Better Life',
                'slug' => 'top-10-health-tips',
                'image' => 'backend/images/placeholder/blog-img-3.png',
                'description' => 'Discover the top health tips to improve your well-being and lead a healthier lifestyle.',
                'sub_description' => 'Health and wellness are essential for a balanced life.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_category_id' => 3,
                'title' => 'Travel Guide to Exotic Destinations',
                'slug' => 'travel-guide-exotic-destinations',
                'image' => 'backend/images/placeholder/blog-img-1.png',
                'description' => 'A comprehensive travel guide to the most exotic destinations in the world.',
                'sub_description' => 'Explore breathtaking places and unique cultures.',
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_category_id' => 4,
                'title' => 'Delicious Recipes for Food Lovers',
                'slug' => 'delicious-recipes-food-lovers',
                'image' => 'backend/images/placeholder/blog-img-3.png',
                'description' => 'A collection of mouthwatering recipes that will delight your taste buds.',
                'sub_description' => 'Food is not just fuel, it’s an experience.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_category_id' => 5,
                'title' => 'Managing Your Finances Like a Pro',
                'slug' => 'managing-finances-like-pro',
                'image' => 'backend/images/placeholder/blog-img-3.png',
                'description' => 'Tips and tricks to manage your finances effectively and achieve your financial goals.',
                'sub_description' => 'Financial management is key to a secure future.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
