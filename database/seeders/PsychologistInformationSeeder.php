<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PsychologistInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('psychologist_information')->insert([
            [
                'user_id' => 3,
                'qualification' => 'Masters in Clinical Psychology',
                'ahpra_registration_number' => 'AHPRA12345',
                'therapy_mode' => 'online',
                'client_age' => '18-60',
                'session_length' => '50 minutes',
                'cust_per_session' => 150.00,
                'medicare_rebate_amount' => 85.50,
                'location' => 'Sydney, Australia',
                'views' => 120,
                'experience' => '5 years',
                'aphra_certificate' => 'backend/images/placeholder/MVP Document (4) (1).pdf',
                'description' => 'Experienced psychologist specializing in anxiety and depression.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'qualification' => 'PhD in Psychology',
                'ahpra_registration_number' => 'AHPRA54321',
                'therapy_mode' => 'offline',
                'client_age' => '30-50',
                'session_length' => '1 hour',
                'cust_per_session' => 200.00,
                'medicare_rebate_amount' => 90.00,
                'location' => 'Melbourne, Australia',
                'views' => 80,
                'experience' => '10 years',
                'aphra_certificate' => 'backend/images/placeholder/MVP Document (4) (1).pdf',
                'description' => 'Specializes in family therapy and cognitive behavioral therapy.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
