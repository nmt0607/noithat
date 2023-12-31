<?php

namespace Database\Seeders;

use App\Models\SurveyDetail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CreateAdminSeeder::class,
            PermissionSeeder::class,
            FaqSeeder::class,
            // AboutUsSeeder::class,
            // BrandSeeder::class,
            CustomersSaySeeder::class,
            NewsSeeder::class,
            ContactSeeder::class,
            SlideHomeSeeder::class,
        ]);
    }
}
