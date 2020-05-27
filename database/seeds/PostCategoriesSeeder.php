<?php

use Illuminate\Database\Seeder;
use  \Dcat\Admin\Auth\Database\Menu;

class PostCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Category::class, 10)->create();
    }
}
