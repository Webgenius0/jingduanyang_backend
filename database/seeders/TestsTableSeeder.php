<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tests')->insert([
            [
                'prescription_id' => 1,
                'test_name' => 'Blood Test',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'prescription_id' => 1,
                'test_name' => 'X-Ray',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'prescription_id' => 2,
                'test_name' => 'MRI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'prescription_id' => 2,
                'test_name' => 'CT Scan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
