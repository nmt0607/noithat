<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $data = require_once(database_path('raw/NewsData.php'));
        DB::table('news')->delete();
        foreach($data as $value){
            DB::table('news')->insert(
                $value,
            );
        }
    }
}