<?php

use Illuminate\Database\Seeder;
use Dcat\Admin\Models\Menu;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Product::class, 10)->create();
        $parent = Menu::create([
            'parent_id' => 0,
            'order'     => 9,
            'title'     =>  __('site.product'),
            'icon'      => 'fa-tag',
            'uri'       => 'products',
        ]);
        if ($parent) {
            Menu::insert([
                [
                    'parent_id' => $parent->id,
                    'order'     => 1,
                    'title'     =>  __('site.product'),
                    'icon'      => 'fa-tag',
                    'uri'       => 'products',
                ],
                [
                    'parent_id' => $parent->id,
                    'order'     => 2,
                    'title'     => __('site.category'),
                    'icon'      => 'fa-server',
                    'uri'       => 'categories/product',
                ],
                [
                    'parent_id' => $parent->id,
                    'order'     => 3,
                    'title'     =>  __('site.add'). __('site.product'),
                    'icon'      => 'fa-plus',
                    'uri'       => 'products/create',
                ]
            ]);
        }
    }
}
