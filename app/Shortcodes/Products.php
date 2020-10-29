<?php
namespace App\Shortcodes;
use App\Models\Product;
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
        $query = Product::query();
        $query->locale();
        if ($dir = $params->getParameter('dir')) {
            $this->dirTemplate = $dir;
        }
        if ($catalogue = $params->getParameter('catalogue')) {
            $query->whereHas('categories', function ($q) use ($catalogue) {
                $q->whereSlug($catalogue);
            });

            if ($catalogue == "ban") {
                $query->where('transaction_type', 29);
            } elseif ($catalogue == "cho-thue") {
                $query->where('transaction_type', 28);
            }
        }
        $limit = $params->getParameter('limit', 10);
        return $query->orderBy('updated_at', 'desc')->with('categories', 'creator')->paginate($limit);
    }
}
