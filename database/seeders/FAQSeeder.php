<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('f_a_q_s')->insert([
            [
                'question' => 'What is your refund policy?',
                'answer' => 'We offer a full refund within 30 days of purchase.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'How can I reset my password?',
                'answer' => 'You can reset your password by clicking on the “Forgot Password” link on the login page.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Do you offer technical support?',
                'answer' => 'Yes, we provide 24/7 technical support through email and chat.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Can I upgrade my plan at any time?',
                'answer' => 'Yes, you can upgrade your plan at any time from your account settings.',
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Where can I view my invoices?',
                'answer' => 'You can view and download your invoices from the billing section of your account.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
