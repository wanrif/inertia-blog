<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);
        $role->givePermissionTo('manage roles', 'manage permissions', 'manage users', 'manage posts');

        $role = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        $role->givePermissionTo('manage roles', 'manage permissions', 'manage users', 'manage posts');

        $role = Role::create([
            'name' => 'author',
            'guard_name' => 'web',
        ]);
        $role->givePermissionTo('manage posts');
    }
}
