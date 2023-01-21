<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'manage users',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'manage roles',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'manage permissions',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'manage posts',
            'guard_name' => 'web',
        ]);
    }
}
