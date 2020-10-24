<?php

use Illuminate\Database\Seeder;
use Dcat\Admin\Models\Menu;

class Tagseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Tag::class, 10)->create();
        $parent = Menu::create([
            'parent_id' => 0,
            'order'     => 9,
            'title'     =>  __('site.tag'),
            'icon'      => 'fa-tag',
            'uri'       => 'tags',
        ]);
        if ($parent) {
            Menu::insert([
                [
                    'parent_id' => $parent->id,
                    'order'     => 1,
                    'title'     =>  __('site.tag'),
                    'icon'      => 'fa-tag',
                    'uri'       => 'tags',
                ],
                [
                    'parent_id' => $parent->id,
                    'order'     => 2,
                    'title'     =>  __('site.add'). __('site.tag'),
                    'icon'      => 'fa-plus',
                    'uri'       => 'tags/create',
                ],
            ]);
        }
    }
}
