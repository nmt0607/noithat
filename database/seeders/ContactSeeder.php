<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $data = require_once(database_path('raw/ContactData.php'));
        DB::table('master_data')->where('type',4)->delete();
        foreach($data as $value){
            DB::table('master_data')->insert(
                $value,
            );
        }
    }
}