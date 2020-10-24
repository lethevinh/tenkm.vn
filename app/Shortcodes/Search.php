<?php
namespace App\Shortcodes;
use App\Entities\Property;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class Search extends AbstractShortcode {

    public static string $name = 'search';

    protected string $dirTemplate = "components/products/";

    function __construct() {

    }

    public function process(ShortcodeInterface $args) {

        $template = $this->getTemplate($args);
        $query = Property::query();
        $page = request()->page;
        if ($content = $page['content']) {
            $catalogue = $content->slug;
            if ($page['type'] == "transaction") {
                $query->where("transaction_type", $content->id);
            } else {
                $query->where("property_type", $content->id);
            }
        }

        $limit = 10;
        $products = $query->orderBy('id', 'desc')->with('thumbnail', 'categories', 'owner')->paginate($limit);
        //  dd($products, $query->toSql(), $content->id, $page);
        return $this->render($template, ["products" => $products]);
    }
}
