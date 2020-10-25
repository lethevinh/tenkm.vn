<?php
namespace App\Shortcodes;
use App\Traits\Cacheable;
use App\Traits\TemplateTrait;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 *
 */
class AbstractShortcode {
    use TemplateTrait,Cacheable;

    public static string $name = "";

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

    public function makeCache($params)
    {
        // TODO: Implement makeCache() method.
    }

    /**
     * @param string $prefix
     * @return string
     */
    public static function cachePrefix($prefix = '')
    {
        $locale = session()->get('locale', config('site.locale_default'));
        $config = config('site.cache.keys.shortcode', 'site-caches');
        return $config . static::$name . '-' . $prefix . '-' . $locale;
    }

    /**
     * @param $model
     * @param array $params
     * @return mixed
     */
    public static function getCacheByName($model, $params = [])
    {
        if (! self::enableCache()) {
            return $model->makeCache($params);
        }
        $template = $model->getTemplate($params);
        $cacheKey = static::cachePrefix($template);
        if (!$model->getStore()->has($cacheKey)) {
            if ($cache = $model->makeCache($params)){
                $model->forever($cache, $cacheKey);
            }
        }
        return $model->getStore()->get($cacheKey);
    }
}
