<?php
namespace App\Shortcodes;
use App\Entities\Category;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 *
 */
class Categories extends AbstractShortcode {

    public static string $name = 'categories';

    protected string $dirTemplate = "components/categories/";

    protected string $defaultTemplate = "default";

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
