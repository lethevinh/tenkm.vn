<?php
namespace App\Shortcodes;
use App\Traits\TemplateTrait;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 *
 */
class AbstractShortcode {
    use TemplateTrait;

    public static string $name;

    protected string $dirTemplate = "";

    protected string $defaultTemplate = "default";

    function __construct() {
        $this->onContruct();
    }

    public function onContruct() {

    }

    final public function handler(ShortcodeInterface $args) {
        $this->addLocationDefault();
        return $this->process($args);
    }

    public function process(ShortcodeInterface $args) {

    }

    private function addLocationDefault() {
        /**
         * add location default can errors choose
         */
        $this->addLocation(theme_dir_view($this->dirTemplate));
    }

    function getTemplate(ShortcodeInterface $args) {
        $template = $this->defaultTemplate;

        if ($this->checkTemplateInCurrentLocation($args->getParameter('template'))) {
            $template = $this->dirTemplate . '.' . $args->getParameter('template');
        }

        return $template;
    }

    public function checkTemplateInCurrentLocation($template) {
        $file = $template . '.blade.php';
        $path = theme_dir_view($this->dirTemplate .'/'. $file);
        return file_exists($path);
    }
}
