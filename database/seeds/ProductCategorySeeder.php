<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\Storage;
use \App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = json_decode(Storage::disk('resource')->get('json/categories.json'), true);
        foreach ($categories as $key => $categoryData) {
            $category = $this->createCategory($categoryData);
            if ($category) {
                foreach ($categoryData['children'] as $children) {
                    $this->createCategory($children, $category);
                }
            }
        }
    }

    function createCategory($category, $parent = null, $type = 'category') {
        switch ($type) {
            case 'category' :
                //provincial
                $parentId = !is_null($parent) ? $parent->id: null;
                return ProductCategory::create([
                    'title_lb' => $category['name'],
                    'type_lb' => 'product',
                    'parent_id' => $parentId,
                    'status_sl' => 'public'
                ]);
                break;
            case 'price' :
                //price
                 ProductCategory::create([
                    'title_lb' => $category['name'],
                    'prefix_lb' => $category['pre'],
                    'parent_id' => $parent->id,
                    'type_lb' => $type,
                    'status_sl' => 'public'
                ]);
                break;
        }
    }
}
