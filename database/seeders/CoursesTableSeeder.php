<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            [
                'title' => 'Laravel for Beginners',
                'slug' => 'laravel-for-beginners',
                'price' => null,
                'type' => 'free',
                'image_url' => 'backend/images/placeholder/education-image.png',
                'video_url' => 'https://www.youtube.com/watch?v=MrXnyctl_Mw',
                'description' => 'Learn the basics of Laravel framework.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Advanced PHP Course',
                'slug' => 'advanced-php-course',
                'price' => '199',
                'type' => 'premium',
                'image_url' => 'backend/images/placeholder/education-image.png',
                'video_url' => 'https://www.youtube.com/watch?v=MrXnyctl_Mw',
                'description' => 'Master advanced PHP techniques.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'JavaScript Fundamentals',
                'slug' => 'javascript-fundamentals',
                'price' => '99',
                'type' => 'premium',
                'image_url' => 'backend/images/placeholder/education-image.png',
                'video_url' => 'https://www.youtube.com/watch?v=MrXnyctl_Mw',
                'description' => 'Understand the core concepts of JavaScript.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'React Basics',
                'slug' => 'react-basics',
                'price' => '149',
                'type' => 'premium',
                'image_url' => 'backend/images/placeholder/education-image.png',
                'video_url' => 'https://www.youtube.com/watch?v=MrXnyctl_Mw',
                'description' => 'Build modern web apps using React.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Node.js API Development',
                'slug' => 'nodejs-api-development',
                'price' => '199',
                'type' => 'premium',
                'image_url' => 'backend/images/placeholder/education-image.png',
                'video_url' => 'https://www.youtube.com/watch?v=MrXnyctl_Mw',
                'description' => 'Learn to create RESTful APIs using Node.js.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Python for Data Science',
                'slug' => 'python-for-data-science',
                'price' => null,
                'type' => 'free',
                'image_url' => 'backend/images/placeholder/education-image.png',
                'video_url' => 'https://www.youtube.com/watch?v=MrXnyctl_Mw',
                'description' => 'Explore data analysis and visualization with Python.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'HTML & CSS Masterclass',
                'slug' => 'html-css-masterclass',
                'price' => null,
                'type' => 'free',
                'image_url' => 'backend/images/placeholder/education-image.png',
                'video_url' => 'https://www.youtube.com/watch?v=MrXnyctl_Mw',
                'description' => 'Learn how to build responsive websites with HTML & CSS.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
