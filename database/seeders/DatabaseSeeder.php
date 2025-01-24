<?php

namespace Database\Seeders;

use App\Models\PaypalProduct;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(SocialMediaSeeder::class);
        $this->call(SystemSettingSeeder::class);
        $this->call(DynamicPageSeeder::class);
        $this->call(FAQSeeder::class);
        $this->call(BlogCategorySeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(CmsSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(ProductImagesSeeder::class);
        $this->call(ProductBenefitsSeeder::class);
        $this->call(QuizzeCategoriesSeeder::class);
        $this->call(QuizzeQuestionsSeeder::class);
        $this->call(PaypalProductSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(OrderProductSeeder::class);
        $this->call(PsychologistInformationSeeder::class);
        $this->call(AppointmentsSeeder::class);
        $this->call(PrescriptionSeeder::class);
        $this->call(MedicineSeeder::class);
        $this->call(TestsTableSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(ReviewImageSeeder::class);
    }
}
