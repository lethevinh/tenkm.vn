<?php
namespace App\Shortcodes;
use App\Models\Career;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class Careers extends AbstractShortcode {

    public static $name = 'careers';


    protected  $dirTemplate = "collection";

    protected  $defaultTemplate = "collection.default";

    function __construct() {

    }

    public function process(ShortcodeInterface $args) {
        $template = $this->getTemplate($args);
        $query = Career::query();

        $limit = 7;
        $projects = $query
            ->where('status_sl', 'public')
            ->orderBy('updated_at', 'desc')
            ->locale()->paginate($limit);
        return $this->render($template, ["careers" => $projects]);
    }
}
