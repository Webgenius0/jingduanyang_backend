<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaypalProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Basic Plan',
                'product_id' => 'PROD-9Y935732SV7881917',
                'plan_id' => 'P-99R43207338157143M6HWVAI',
                'price' => '70.00',
            ],
            [
                'name' => 'Premium Plan',
                'product_id' => 'PROD-2PH39733CR297952U',
                'plan_id' => 'P-2LP789196P282721XM6HZWHI',
                'price' => '150.00',
            ],
            [
                'name' => 'VIP Plan',
                'product_id' => 'PROD-3VB872146G619144J',
                'plan_id' => 'P-6TG66054BS6419228M6HZWYA',
                'price' => '300.00',
            ],
        ];

        foreach ($products as $product) {
            \App\Models\PaypalProduct::create($product);
        }
    }
}
