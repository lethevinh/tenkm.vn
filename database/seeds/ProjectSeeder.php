<?php

use Illuminate\Database\Seeder;
use Dcat\Admin\Models\Menu;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Project::class, 10)->create();
        $parent = Menu::create([
            'parent_id' => 0,
            'order'     => 9,
            'title'     =>  __('site.project'),
            'icon'      => 'fa-tag',
            'uri'       => 'projects',
        ]);
        if ($parent) {
            Menu::insert([
                [
                    'parent_id' => $parent->id,
                    'order'     => 1,
                    'title'     =>  __('site.project'),
                    'icon'      => 'fa-tag',
                    'uri'       => 'projects',
                ],
                [
                    'parent_id' => $parent->id,
                    'order'     => 2,
                    'title'     => __('site.category'),
                    'icon'      => 'fa-server',
                    'uri'       => 'categories/project',
                ],
                [
                    'parent_id' => $parent->id,
                    'order'     => 3,
                    'title'     =>  __('site.add'). __('site.project'),
                    'icon'      => 'fa-plus',
                    'uri'       => 'projects/create',
                ]
            ]);
        }
    }
}
