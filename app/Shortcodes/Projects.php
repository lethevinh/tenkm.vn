<?php
namespace App\Shortcodes;
use App\Entities\Project;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class Projects extends AbstractShortcode {

    public static $name = 'projects';

    protected  $dirTemplate = "components/projects/";

    function __construct() {

    }

    public function process(ShortcodeInterface $args) {
        $template = $this->getTemplate($args);
        $query = Project::query();

        $limit = 7;
        $projects = $query->where('status_sl', 'public')
            ->locale()
            ->orderBy('updated_at', 'desc')->with('thumbnail', 'categories', 'owner')
            ->paginate($limit);
        return $this->render($template, ["projects" => $projects]);
    }
}
