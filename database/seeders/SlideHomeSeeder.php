<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlideHomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $data = require_once(database_path('raw/SlideHomeData.php'));
        DB::table('master_data')->where('type',5)->delete();
        foreach($data as $value){
            DB::table('master_data')->insert(
                $value,
            );
        }
    }
}