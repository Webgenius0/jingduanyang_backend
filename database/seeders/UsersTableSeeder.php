<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'remember_token' => Str::random(10),
                'created_at' => now(),
            ],
            [
                'first_name' => 'client',
                'email' => 'client@client.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'role' => 'client',
                'remember_token' => Str::random(10),
                'created_at' => now(),
            ],
            [
                'first_name' => 'doctor',
                'email' => 'doctor@doctor.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'role' => 'doctor',
                'remember_token' => Str::random(10),
                'created_at' => now(),
            ],
        ]);
    }
}
