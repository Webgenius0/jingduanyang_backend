<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('teams')->insert([
            [
                'name' => 'Dr. John Smith',
                'specialty' => 'Cardiologist',
                'experience' => '10 Years',
                'phone_one' => '123-456-7890',
                'phone_two' => '098-765-4321',
                'location' => 'New York, USA',
                'specializes' => 'Heart surgeries, ECG analysis, and heart disease prevention.',
                'about' => 'Dr. John Smith is a renowned cardiologist with over a decade of experience in treating cardiovascular diseases.',
                'consult_duration' => '30 minutes',
                'total_fees' => 150,
                'image_url' => 'backend/images/placeholder/doctor.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Emily Johnson',
                'specialty' => 'Dermatologist',
                'experience' => '8 Years',
                'phone_one' => '456-789-0123',
                'phone_two' => null,
                'location' => 'Los Angeles, USA',
                'specializes' => 'Skin treatments, acne, and anti-aging solutions.',
                'about' => 'Dr. Emily Johnson is a certified dermatologist who has helped thousands of patients achieve healthy skin.',
                'consult_duration' => '45 minutes',
                'total_fees' => 120,
                'image_url' => 'backend/images/placeholder/doctor.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Michael Brown',
                'specialty' => 'Orthopedic Surgeon',
                'experience' => '12 Years',
                'phone_one' => '789-012-3456',
                'phone_two' => '321-654-0987',
                'location' => 'Chicago, USA',
                'specializes' => 'Joint replacements, sports injuries, and spine surgery.',
                'about' => 'Dr. Michael Brown is an experienced orthopedic surgeon specializing in complex joint surgeries.',
                'consult_duration' => '60 minutes',
                'total_fees' => 200,
                'image_url' => 'backend/images/placeholder/doctor.png',
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Sarah Williams',
                'specialty' => 'Pediatrician',
                'experience' => '7 Years',
                'phone_one' => '234-567-8901',
                'phone_two' => '654-321-0987',
                'location' => 'Houston, USA',
                'specializes' => 'Child healthcare, vaccinations, and growth monitoring.',
                'about' => 'Dr. Sarah Williams is a dedicated pediatrician who ensures the well-being of children from infancy to adolescence.',
                'consult_duration' => '40 minutes',
                'total_fees' => 100,
                'image_url' => 'backend/images/placeholder/doctor.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. David Wilson',
                'specialty' => 'Psychologist',
                'experience' => '9 Years',
                'phone_one' => '345-678-9012',
                'phone_two' => null,
                'location' => 'San Francisco, USA',
                'specializes' => 'Mental health, stress management, and behavioral therapy.',
                'about' => 'Dr. David Wilson is a licensed psychologist who helps patients achieve mental wellness through counseling and therapy.',
                'consult_duration' => '50 minutes',
                'total_fees' => 130,
                'image_url' => 'backend/images/placeholder/doctor.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
