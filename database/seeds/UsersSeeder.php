<?php

use Dcat\Admin\Models\Menu;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Skill;
use App\Models\Certificate;
use App\Models\Resource;
use App\Models\Package;
use App\Models\Category;
use App\Models\Post;
use App\Models\Event;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)
            ->create();
        $parent = Menu::create([
            'parent_id' => 0,
            'order'     => 9,
            'title'     => __('admin.user'),
            'icon'      => 'fa-users',
            'uri'       => 'users',
        ]);
        if ($parent) {
            Menu::insert([
                [
                    'parent_id' => $parent->id,
                    'order'     => 1,
                    'title'     => __('admin.user'),
                    'icon'      => 'fa-users',
                    'uri'       => 'users',
                ],
                [
                    'parent_id' => $parent->id,
                    'order'     => 2,
                    'title'     => __('site.add').__('admin.user'),
                    'icon'      => 'fa-user-plus',
                    'uri'       => 'users/create',
                ],
            ]);
        }
    }
}
