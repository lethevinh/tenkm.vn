<?php
namespace App\Shortcodes;
use App\Entities\Post as PostModel;
use App\Traits\PageTrait;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 *
 */
class Post extends AbstractShortcode {
    use PageTrait;

    public static $name = 'post';

    protected  $dirTemplate = "components/post/";

    protected  $defaultTemplate = "default";

    function __construct() {

    }
    public function process(ShortcodeInterface $args) {

        if (!$slug = $this->getParameter('slug')) {
            dd('not found');
        }
        $post = PostModel::with('thumbnail')->where('slug', $slug)->first();

        if (!$post) {
            dd('not found ');
        }

        $template = $this->getTemplate($args);
        return $this->render($template, ["post" => $post]);
    }
}
