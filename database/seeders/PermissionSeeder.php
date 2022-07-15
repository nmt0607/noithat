<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        // $actions = ['list', 'create-edit', 'delete'];

        // $routes = Route::getRoutes()->getRoutes();
        // foreach ($routes as $route) {
        //     if (!isset($route->action['middleware'])) continue;
        //     if (!is_array($route->action['middleware'])) continue;
        //     if (!in_array('route-permission', $route->action['middleware'] ?? [])) continue;
            
        //     $routeName = $route->action['as'] ?? 'route-name';
        //     if (strpos($routeName, '.index') > 0) {
        //         $arr = explode('.', $routeName);
        //         array_pop($arr);
        //         $alias = $arr;
        //         if ($alias[0] == 'admin') {
        //             unset($alias[0]);
        //         }
        //         if ($arr[0] != 'admin') {
        //             array_splice($arr,0,0,'admin');
        //         }
        //         foreach ($actions as $action) {
        //             Permission::query()->firstOrCreate([
        //                 'alias' => join('-', $alias),
        //                 'code' => join('.', $arr) . '.index',
        //                 'name' => join('.', $arr) . '.' . $action,
        //                 'action' => $action,
        //                 'guard_name' => 'web'
        //             ]);
        //         }
        //     }
        // }

        // $role = Role::firstOrCreate([
        //     'name' => 'administrator',
        //     'guard_name' => 'web',
        // ]);

        // $role->syncPermissions(Permission::all());

        // User::findorfail(1)->assignRole($role);
    }
}
