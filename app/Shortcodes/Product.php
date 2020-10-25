<?php
namespace App\Shortcodes;
use App\Entities\Property as ProductModel;
use App\Traits\PageTrait;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class Product extends AbstractShortcode {
    use PageTrait;

    public static $name = 'product';

    protected  $dirTemplate = "components/product/";

    function __construct() {
        parent::__construct();
    }

    public function process(ShortcodeInterface $args) {

        if (!$slug = $this->getParameter('slug')) {
            return $this->render(['404'], [
            ]);
        }

        $product = ProductModel::with(['owner', 'project', 'categories', 'location', 'thumbnail', 'photos'])->where('slug', $slug)->first();

        if (!$product) {
            return $this->render(['404'], [
            ]);
        }

        $related = ProductModel::with(['thumbnail'])->where('property_type', $product->property_type)->limit(10)->get();

        $template = $this->getTemplate($args);

        return $this->render([$template, 'components/product/default'], [
            "product" => $product,
            "related" => $related,
        ]);

    }
}
