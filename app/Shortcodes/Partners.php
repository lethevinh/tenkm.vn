<?php
namespace App\Shortcodes;
use App\Entities\Project;
use App\Models\Partner;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class Partners extends AbstractShortcode {

    public static $name = 'partners';


    protected  $dirTemplate = "collection";

    protected  $defaultTemplate = "collection.default";

    function __construct() {

    }

    public function process(ShortcodeInterface $args) {
        $template = $this->getTemplate($args);
        $query = Partner::query();

        $limit = 7;
        $projects = $query->orderBy('updated_at', 'desc')->paginate($limit);
        return $this->render($template, ["partners" => $projects]);
    }
}
