<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        SystemSetting::insert([
            [
                'id'             => 1,
                'title'          => 'RKB Is The Best!🪄',
                'email'          => 'support@gmail.com',
                'phone'          => '0174354342',
                'support_phone'  => '02342342354',
                'address'        => null,
                'system_name'    => 'Laravel Stater Kit',
                'copyright_text' => 'Copyright © 2017 - 2024 DESIGN AND DEVELOPED BY RKB❤️',
                'logo'           => null,
                'favicon'        => null,
                'description'    => 'The Description',
                'created_at'     => Carbon::now(),
            ],
        ]);
    }
}
