<?php
namespace App\Shortcodes;
use App\Services\Menu;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class Menus extends AbstractShortcode {

    public static string $name = 'menus';

    protected string $dirTemplate = "components/menus/";

    protected string $defaultTemplate = "default";

    function __construct() {

    }
    public function process(ShortcodeInterface $args) {

        $template = $this->getTemplate($args);

        $menu = Menu::getMenu($args->getParameter('name'));
        return $this->render($template, ["menu" => $menu]);
    }
}
