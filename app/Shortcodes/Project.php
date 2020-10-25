<?php
namespace App\Shortcodes;
use App\Entities\Project as ProjectModel;
use App\Traits\PageTrait;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class Project extends AbstractShortcode {

    use PageTrait;

    public static $name = 'project';

    protected  $dirTemplate = "components/project/";

    function __construct() {
        parent::__construct();
    }

    public function process(ShortcodeInterface $args) {

        if (!$slug = $this->getParameter('slug')) {
            dd('not found slug project');
        }
        $project = ProjectModel::with('categories', 'location', "thumbnail", "photos")->where('slug', $slug)->first();

        if (!$project) {
            dd('not found project ');
        }
        // dd($project);
        $template = $this->getTemplate($args);
        return $this->render([$template], ["project" => $project]);
    }
}
