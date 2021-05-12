<?php
namespace App\Shortcodes;
use App\Models\Product;
use App\Models\ProductCategory;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class Products extends AbstractShortcode {

    public static $name = 'products';

    protected  $dirTemplate = "collection";

    protected  $defaultTemplate = "collection.default";

    function __construct() {

    }

    public function process(ShortcodeInterface $args) {
        $template = $this->getTemplate($args);
        $data =  static::getCacheByName($this, $args);
       return $this->render($template, ['products' => $data]);
    }

    public function makeCache($params)
    {
        $limit = $params->getParameter('limit', 10);
        if ($dir = $params->getParameter('dir')) {
            $this->dirTemplate = $dir;
        }
        $locale = session()->get('locale', config('site.locale_default'));
        if ($categorySlug = $params->getParameter('category')) {
            $category = ProductCategory::whereSlugLb($categorySlug)->first();
            if ($translation = $category->translation($locale)) {
              $category = $translation;
            }
            if ($category){
                return $category->products()
                    ->where('end_of_contract','<>', 1)
                    ->where('status_sl', 'public')
                    ->locale()->orderBy('updated_at', 'desc')
                    ->with('categories', 'creator')->paginate($limit);
            }
        }
        $query = Product::query();
        $query->locale();
        return $query
            ->where('status_sl', 'public')
            ->where('end_of_contract','<>', 1)
            ->orderBy('updated_at', 'desc')
            ->with('categories', 'creator')->paginate($limit);
    }
}
