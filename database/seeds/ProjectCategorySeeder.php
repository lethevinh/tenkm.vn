<?php

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\Storage;
use \App\Models\ProductCategory;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function run()
    {
        $categories = json_decode(Storage::disk('resource')->get('json/project-categories.json'), true);
        foreach ($categories as $key => $category) {
            \App\Models\ProjectCategory::create([
                'title_lb' => $category['name']
            ]);
        }
    }
}
