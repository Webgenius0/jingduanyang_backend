<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prescriptions')->insert([
            [
                'user_id' => 3,
                'appointment_id' => 1,
                'date' => '2025-01-01',
                'age' => '25',
                'gender' => 'Male',
                'test_notes' => 'Blood Test Required',
                'medicine_notes' => 'Paracetamol 500mg twice daily',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'appointment_id' => 2,
                'date' => '2025-01-02',
                'age' => '30',
                'gender' => 'Male',
                'test_notes' => 'X-Ray Required',
                'medicine_notes' => 'Ibuprofen 400mg thrice daily',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
