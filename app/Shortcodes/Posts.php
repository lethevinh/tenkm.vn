<?php
namespace App\Shortcodes;
use App\Models\Post;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 *
 */
class Posts extends AbstractShortcode {

    public static string $name = 'posts';

    protected string $dirTemplate = "item/post";

    protected string $defaultTemplate = "collection.default";

    public function process(ShortcodeInterface $args) {

        $template = $this->getTemplate($args);
        $query = Post::query();
        $page = request()->page;
        if ($page && isset($page['type'])) {
            $query->whereHas('categories', function ($q) use ($page) {
                $q->whereSlug($page['slug']);
            });
        }

        $limit = 10;
        $posts = $query->with('categories')->orderBy('updated_at', 'desc')->paginate($limit);
        return $this->render($template, ["posts" => $posts]);
    }
}
