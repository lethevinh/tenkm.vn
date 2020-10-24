<?php
namespace App\Traits;
use App\Services\Theme;
trait PageTrait {

    public $themeTrait;

    public function __construct() {
//        $this->themeTrait = new Theme();
    }
    public function getParameters() {
//        $theme = new Theme();
        $router = $theme->findRouterByUri(request()->path());
        return $router->getParameters();
    }

    public function getParameter($key) {
        $parameters = $this->getParameters();
        if (array_key_exists($key, $parameters)) {
            $value = $parameters[$key];
            if (str_is('*.html', $value)) {
                $value = str_replace('.html', "", $value);
            }
            return $value;
        }
        return false;
    }
}
