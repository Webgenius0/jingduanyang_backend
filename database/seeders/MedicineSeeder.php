<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('medicines')->insert([
            [
                'prescription_id' => 1,
                'medicine_name' => 'Paracetamol',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'prescription_id' => 1,
                'medicine_name' => 'Ibuprofen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'prescription_id' => 2,
                'medicine_name' => 'Amoxicillin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'prescription_id' => 2,
                'medicine_name' => 'Azithromycin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
