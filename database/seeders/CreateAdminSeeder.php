<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->truncate();
        $admin = User::firstOrCreate([
            'name' => 'Hassan Raza',
            'email' => 'admin@test.com',
            'password' => Hash::make('123456')
        ]);
        $admin2 = User::firstOrCreate([
            'name' => 'User test',
            'email' => 'user@test.com',
            'password' => Hash::make('123456')
        ]);


    }
}
