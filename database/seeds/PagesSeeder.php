<?php

use Dcat\Admin\Models\Menu;
use Illuminate\Database\Seeder;
use \App\Models\Page;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parent = Menu::create([
            'parent_id' => 0,
            'order'     => 10,
            'title'     => __('site.page'),
            'icon'      => 'fa-bars',
            'uri'       => 'posts',
        ]);
        if ($parent) {
            Menu::insert([
                [
                    'parent_id' => $parent->id,
                    'order'     => 1,
                    'title'     => __('site.page'),
                    'icon'      => 'fa-bars',
                    'uri'       => 'pages',
                ],
                [
                    'parent_id' => $parent->id,
                    'order'     => 2,
                    'title'     => __('site.add').__('site.page'),
                    'icon'      => 'fa-plus-square',
                    'uri'       => 'pages/create',
                ],
            ]);
        }
    }
}
