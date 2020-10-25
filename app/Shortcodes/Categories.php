<?php
namespace App\Shortcodes;
use App\Entities\Category;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 *
 */
class Categories extends AbstractShortcode {

    public static $name = 'categories';

    protected  $dirTemplate = "components/categories/";

    protected  $defaultTemplate = "default";

    function __construct() {

    }

    public function process(ShortcodeInterface $args) {
        $template = $this->getTemplate($args);
        $limit = 10;
        $type = $args->getParameter('type');
        $type = $type ? $type : "post";
        $categories = Category::where('type', $type)->paginate($limit);
        return $this->render($template, ["categories" => $categories]);
    }
}
