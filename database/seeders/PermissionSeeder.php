<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'can manage users',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'can manage roles',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'can manage permissions',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'can manage posts',
            'guard_name' => 'web',
        ]);
    }
}
