<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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

        // $superAdmin->posts()->create([
        //     'title' => 'My First Post',
        //     'slug' => Str::slug('My First Post') . '-' . Str::random(5),
        //     'body' => 'This is my first post',
        // ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@role.test',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin');

        // $admin->posts()->create([
        //     'title' => 'My First Post',
        //     'slug' => Str::slug('My First Post') . '-' . Str::random(5),
        //     'body' => 'This is my first post',
        // ]);

        $author = User::create([
            'name' => 'Author',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $author->assignRole('author');
        $author->posts()->create([
            'title' => 'My First Post',
            'slug' => Str::slug('My First Post').'-'.strtolower(Str::random(6)),
            'category_id' => 1,
            'body' => '<p>Lorem ipsum dolor sit amet posuere tellus nulla. Odio quam inceptos vel nibh viverra tortor bibendum aliquet vehicula. Hac sollicitudin adipiscing euismod egestas si dictum imperdiet est volutpat. Venenatis turpis facilisis montes mollis suscipit volutpat habitasse at mus. Fusce venenatis hendrerit pharetra interdum lacinia inceptos ut. Ante leo finibus platea curabitur viverra vivamus. Maecenas ex sed sapien rhoncus purus mattis risus eleifend cubilia.</p>

            <p>Class hac dapibus litora justo si velit integer dignissim mauris ex nisl. Sagittis aliquet nam semper suscipit vehicula mauris. Hendrerit feugiat accumsan vivamus elementum donec adipiscing facilisis faucibus pellentesque metus maximus. Tristique amet tincidunt massa scelerisque pede nec cras laoreet maximus cursus. Vulputate morbi et inceptos mauris nisi. Id sociosqu tortor accumsan commodo amet senectus sem ut quisque dolor torquent.</p>',
        ]);

        $author2 = User::create([
            'name' => 'Author 2',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
        ]);

        $author2->assignRole('author');
        $author2->posts()->create([
            'title' => 'My First Post',
            'slug' => Str::slug('My First Post').'-'.strtolower(Str::random(6)),
            'category_id' => 2,
            'body' => '<p>Lorem ipsum dolor sit amet lacinia aliquam aenean semper interdum. Venenatis semper conubia vel enim libero taciti quis metus imperdiet. Montes potenti sodales commodo elit hendrerit est lorem sed netus amet nec. Leo massa sapien auctor himenaeos ullamcorper. Purus feugiat cras nulla vel libero dis lacinia sagittis massa diam quis. Suscipit scelerisque orci ut penatibus habitasse non. Vitae ultrices pharetra elit penatibus ligula. Dolor lacinia nullam netus maximus vivamus elementum ultricies.</p>

            <p>Pretium malesuada dis tempus dui finibus tempor cursus luctus diam ante. Non vulputate ultrices massa cursus letius maecenas penatibus consectetur. Mollis aptent semper lacus sit mus letius. Curae at erat eu dictum letius nullam tristique nostra.</p>

            <p>Libero etiam sagittis faucibus praesent pretium. Platea magna finibus aliquet dapibus phasellus integer pede imperdiet. Habitasse proin lorem odio vehicula sodales erat elit pharetra scelerisque et ultrices. Molestie sociosqu dolor luctus litora hac conubia. Sodales proin facilisi suspendisse quisque aenean. Dictumst consectetur natoque bibendum rutrum semper. Feugiat eget adipiscing tristique ut ac fringilla nibh. Arcu auctor sapien conubia vitae faucibus vel sed pellentesque feugiat.</p>',
        ]);
    }
}