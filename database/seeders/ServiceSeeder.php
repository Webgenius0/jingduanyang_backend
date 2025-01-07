<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'title' => 'Web Development',
                'slug' => 'web-development',
                'image' => 'backend/images/placeholder/image_placeholder.png',
                'icon' => 'fa-code',
                'description' => 'We provide custom web development solutions using modern technologies.',
                'sub_description' => 'Our web development services ensure fast, secure, and scalable applications.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Graphic Design',
                'slug' => 'graphic-design',
                'image' => 'backend/images/placeholder/image_placeholder.png',
                'icon' => 'fa-paint-brush',
                'description' => 'Our graphic design services create visually appealing designs to enhance your brand.',
                'sub_description' => 'We deliver creative and unique design solutions.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'image' => 'backend/images/placeholder/image_placeholder.png',
                'icon' => 'fa-bullhorn',
                'description' => 'Boost your online presence with our comprehensive digital marketing strategies.',
                'sub_description' => 'We focus on SEO, PPC, content marketing, and more.',
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'image' => 'backend/images/placeholder/image_placeholder.png',
                'icon' => 'fa-mobile-alt',
                'description' => 'We develop user-friendly mobile applications for Android and iOS platforms.',
                'sub_description' => 'Our apps are designed to deliver an excellent user experience.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'SEO Services',
                'slug' => 'seo-services',
                'image' => 'backend/images/placeholder/image_placeholder.png',
                'icon' => 'fa-search',
                'description' => 'Enhance your website’s visibility on search engines with our SEO services.',
                'sub_description' => 'We help improve your website rankings and drive organic traffic.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
