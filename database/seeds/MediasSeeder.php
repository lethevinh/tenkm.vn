<?php

use Dcat\Admin\Models\Menu;
use Illuminate\Database\Seeder;
use App\Models\Media;

class MediasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Media::class, 50)->create();
        $parent = Menu::create([
            'parent_id' => 0,
            'order'     => 9,
            'title'     => __('site.media'),
            'icon'      => 'fa-file-video-o',
            'uri'       => 'medias',
        ]);
        if ($parent) {
            Menu::insert([
                [
                    'parent_id' => $parent->id,
                    'order'     => 1,
                    'title'     => __('site.media'),
                    'icon'      => 'fa-file-video-o',
                    'uri'       => 'medias',
                ],
                [
                    'parent_id' => $parent->id,
                    'order'     => 2,
                    'title'     => __('site.add').__('site.media'),
                    'icon'      => 'fa-plus',
                    'uri'       => 'medias/create',
                ],
            ]);
        }
    }
}
