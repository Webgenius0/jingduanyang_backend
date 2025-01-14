<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuizzeCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'title' => 'Science',
                'slug' => Str::slug('Science'),
                'icon' => 'backend/images/placeholder/meet.png',
                'sub_description' => 'Quizzes related to scientific topics.',
                'status' => 'active',
            ],
            [
                'title' => 'History',
                'slug' => Str::slug('History'),
                'icon' => 'backend/images/placeholder/meet.png',
                'sub_description' => 'Quizzes related to historical events and figures.',
                'status' => 'active',
            ],
            [
                'title' => 'Geography',
                'slug' => Str::slug('Geography'),
                'icon' => 'backend/images/placeholder/meet.png',
                'sub_description' => 'Quizzes related to geographical knowledge.',
                'status' => 'inactive',
            ],
            [
                'title' => 'Sports',
                'slug' => Str::slug('Sports'),
                'icon' => 'backend/images/placeholder/meet.png',
                'sub_description' => 'Quizzes covering different sports and athletes.',
                'status' => 'active',
            ],
            [
                'title' => 'Technology',
                'slug' => Str::slug('Technology'),
                'icon' => 'backend/images/placeholder/meet.png',
                'sub_description' => 'Quizzes on technological advancements and innovations.',
                'status' => 'active',
            ],
            [
                'title' => 'Movies',
                'slug' => Str::slug('Movies'),
                'icon' => 'backend/images/placeholder/meet.png',
                'sub_description' => 'Quizzes related to movies, actors, and directors.',
                'status' => 'inactive',
            ],
            [
                'title' => 'Music',
                'slug' => Str::slug('Music'),
                'icon' => 'backend/images/placeholder/meet.png',
                'sub_description' => 'Quizzes covering different genres of music and artists.',
                'status' => 'active',
            ],
            [
                'title' => 'Literature',
                'slug' => Str::slug('Literature'),
                'icon' => 'backend/images/placeholder/meet.png',
                'sub_description' => 'Quizzes on famous books, authors, and literary works.',
                'status' => 'active',
            ],
            
        ];

        DB::table('quizze_categories')->insert($categories);
    }
}
