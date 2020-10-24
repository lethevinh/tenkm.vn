<?php
namespace App\Shortcodes;
use App\Models\Product;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class Products extends AbstractShortcode {

    public static string $name = 'products';

    protected string $dirTemplate = "collection";

    protected string $defaultTemplate = "collection.default";

    function __construct() {

    }

    public function process(ShortcodeInterface $args) {
        $template = $this->getTemplate($args);
        $query = Product::query();

        if ($catalogue = $args->getParameter('catalogue')) {
            $query->whereHas('categories', function ($q) use ($catalogue) {
                $q->whereSlug($catalogue);
            });

            if ($catalogue == "ban") {
                $query->where('transaction_type', 29);
            } elseif ($catalogue == "cho-thue") {
                $query->where('transaction_type', 28);
            }
        }

        $limit = $args->getParameter('limit', 10);
        $products = $query->orderBy('updated_at', 'desc')->with('categories', 'creator')->paginate($limit);
        // dd($products[0]);
        return $this->render($template, ["products" => $products]);
    }
}
