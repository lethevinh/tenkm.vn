<?php
namespace App\Shortcodes;
use App\Services\Menu;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class Menus extends AbstractShortcode {

    public static $name = 'menus';

    protected  $dirTemplate = "components/menus/";

    protected  $defaultTemplate = "default";

    function __construct() {

    }
    public function process(ShortcodeInterface $args) {

        $template = $this->getTemplate($args);

        $menu = Menu::getMenu($args->getParameter('name'));
        return $this->render($template, ["menu" => $menu]);
    }
}
