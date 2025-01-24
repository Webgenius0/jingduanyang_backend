<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('appointments')->insert([
            [
                'user_id' => 2,
                'psychologist_information_id' => 1,
                'first_name' => 'client',
                'last_name' => null,
                'email' => 'client@client.com',
                'phone' => '1234567890',
                'age' => 25,
                'gender' => 'male',
                'consultant_type' => 'Therapy',
                'appointment_date' => '2025-02-01',
                'appointment_time' => '10:00 AM',
                'available_day' => 'Monday',
                'available_times' => '5:00 PM',
                'meting_link' => 'https://example.com/meeting/johndoe',
                'note' => 'Looking forward to the session.',
                'message' => 'I need help with anxiety issues.',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'psychologist_information_id' => 2,
                'first_name' => 'client',
                'last_name' => null,
                'email' => 'client@client.com',
                'phone' => '0987654321',
                'age' => 30,
                'gender' => 'female',
                'consultant_type' => 'Counseling',
                'appointment_date' => '2025-02-05',
                'appointment_time' => '2:00 PM',
                'available_day' => null,
                'available_times' => null,
                'meting_link' => null,
                'note' => 'First-time consultation.',
                'message' => 'I’d like to discuss my career stress.',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
