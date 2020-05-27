<?php

use Dcat\Admin\Models\Menu;
use Illuminate\Database\Seeder;
use \App\Models\Post;
use \App\Models\Category;
use App\Models\Reaction;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $categories = Category::all()->pluck('id');
        $reactions = Reaction::all()->pluck('id');
        factory(Post::class, 10)
            ->create()
            ->each(function ($post) use ($categories , $reactions,  $faker) {
                for ($x = 0; $x <= 5; $x++) {
                    $category = $faker->randomElement($categories);
                    $reaction = $faker->randomElement($reactions);
                    $post->categorize($category);
                    $post->reaction($reaction);
                    $post->attachTag('Tag Post ' . $faker->sentence(1));
                    $status = $faker->randomElement(['public', 'draft', 'private', 'trash']);
                    $comment = $post->comment([
                        'title_lb' => $faker->title,
                        'body_lb' => $faker->text,
                        'status_sl' => $status
                    ]);
                    if ($comment) {
                        $comment->comment([
                            'title_lb' => $faker->title,
                            'body_lb' => $faker->text,
                            'status_sl' => $status
                        ]);
                    }
                    $post->rating([
                        'title_lb' => $faker->title,
                        'body_lb' => $faker->text,
                        'rating_nb' => $faker->numberBetween(0, 10)
                    ]);
                }
            });
        $parent = Menu::create([
            'parent_id' => 0,
            'order'     => 9,
            'title'     => __('site.news'),
            'icon'      => 'fa-newspaper-o',
            'uri'       => 'posts',
        ]);
        if ($parent) {
            Menu::insert([
                [
                    'parent_id' => $parent->id,
                    'order'     => 1,
                    'title'     => __('site.news'),
                    'icon'      => 'fa-newspaper-o',
                    'uri'       => 'posts',
                ],
                [
                    'parent_id' => $parent->id,
                    'order'     => 2,
                    'title'     => __('site.category'),
                    'icon'      => 'fa-server',
                    'uri'       => 'categories/post',
                ],
                [
                    'parent_id' => $parent->id,
                    'order'     => 3,
                    'title'     => __('site.add').__('site.news'),
                    'icon'      => 'fa-plus',
                    'uri'       => 'posts/create',
                ],
            ]);
        }
    }
}
