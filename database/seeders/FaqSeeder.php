<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Faq;
class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $data = require_once(database_path('raw/FaqData.php'));
        Faq::query()->delete();
        foreach($data as $value){
            Faq::create(
                $value,
            );
        }

    }
}
