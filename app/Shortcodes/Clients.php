<?php
namespace App\Shortcodes;
use App\Entities\Project;
use App\Models\Client;
use App\Models\Partner;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class Clients extends AbstractShortcode {

    public static $name = 'clients';


    protected  $dirTemplate = "collection";

    protected  $defaultTemplate = "collection.default";

    function __construct() {

    }

    public function process(ShortcodeInterface $args) {
        $template = $this->getTemplate($args);
        $query = Client::query();

        $limit = 7;
        $projects = $query
            ->where('status_sl', 'public')
            ->orderBy('updated_at', 'desc')
            ->locale()->paginate($limit);
        return $this->render($template, ["clients" => $projects]);
    }
}
