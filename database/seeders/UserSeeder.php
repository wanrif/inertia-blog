<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@role.test',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $superAdmin->assignRole('super-admin');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@role.test',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin');

        $author = User::create([
            'name' => 'Author',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $author->assignRole('author');

        $author2 = User::create([
            'name' => 'Author 2',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
        ]);

        $author2->assignRole('author');
    }
}
