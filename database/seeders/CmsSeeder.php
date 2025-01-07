<?php

namespace Database\Seeders;

use App\Enum\Page;
use App\Enum\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('c_m_s')->insert([
            [
                'page_name' => Page::HOME->value,
                'section_name' => Section::HERO_SECTION->value,
                'title' => 'Welcome to Our Website',
                'sub_title' => 'Discover Amazing Content',
                'image_url' => null,
                'background_image' => null,
                'description' => 'This is the main hero section description.',
                'sub_description' => null,
                'button_text' => null,
                'button_url' => null,
                'other' => null,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_name' => Page::ABOUT_US->value,
                'section_name' => Section::ABOUT_US_SECTION->value,
                'title' => 'Welcome to Our Website',
                'sub_title' => null,
                'image_url' => 'backend/images/placeholder/image_placeholder.png',
                'background_image' => null,
                'description' => 'This is the main hero section description.',
                'sub_description' => null,
                'button_text' => null,
                'button_url' => null,
                'other' => null,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
