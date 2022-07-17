<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $data = require_once(database_path('raw/AboutUsData.php'));
        DB::table('master_data')->where('type',1)->delete();
        foreach($data as $value){
            DB::table('master_data')->insert(
                $value,
            );
        }
    }
}