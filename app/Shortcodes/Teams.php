<?php
namespace App\Shortcodes;
use App\Models\Team;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class Teams extends AbstractShortcode {

    public static $name = 'teams';


    protected  $dirTemplate = "collection";

    protected  $defaultTemplate = "collection.default";

    function __construct() {

    }

    public function process(ShortcodeInterface $args) {
        $template = $this->getTemplate($args);
        $query = Team::query();

        $limit = 7;
        $projects = $query
            ->where('status_sl', 'public')
            ->orderBy('updated_at', 'desc')
            ->locale()->paginate($limit);
        return $this->render($template, ["teams" => $projects]);
    }
}
