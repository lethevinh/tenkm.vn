<?php
namespace App\Shortcodes;
use App\Models\Post;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 *
 */
class Posts extends AbstractShortcode {

    public static $name = 'posts';

    protected  $dirTemplate = "collection";

    protected  $defaultTemplate = "collection.default";

    public function process(ShortcodeInterface $args) {

        if ($dir = $args->getParameter('dir')) {
            $this->dirTemplate = $dir;
        }
        $template = $this->getTemplate($args);
        $query = Post::query();
        $page = request()->page;
        if ($page && isset($page['type'])) {
            $query->whereHas('categories', function ($q) use ($page) {
                $q->whereSlug($page['slug']);
            });
        }
        $itemTemplate = $args->getParameter('template');
        $limit = 10;
        $posts = $query->with('categories')
            ->where('status_sl', 'public')
            ->locale()
            ->orderBy('updated_at', 'desc')->paginate($limit);
        return $this->render($template, ["posts" => $posts, "template" => $itemTemplate]);
    }
}
