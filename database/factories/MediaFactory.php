<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Media;
use Faker\Generator as Faker;
use \Dcat\Admin\Models\Administrator;

$factory->define(Media::class, function (Faker $faker) {
    $status = $faker->randomElement(['public', 'draft', 'private', 'trash']);
    $admin = Administrator::first();
    $file = 'files/oceans.mp4';
    $type = $faker->randomElement(['file', 'video']);
    if ($type === 'file') {
        $file = 'files/document-course-'.$faker->randomElement(['1', '2', '3']).'.pdf';
    }
    if ($type === 'video') {
        $file = 'files/video-course-'.$faker->randomElement(['1', '2', '3']).'.mp4';
    }
    $image = '/assets/img/dummy_blog_img-' . $faker->randomElement(['1', '2', '3']) . '.jpg';
    return [
        'title_lb' => 'Media ' . $faker->sentence(3),
        'image_lb' => $image,
        'ext_lb' => $type,
        'status_sl' => 'public',
        'type_lb' => $type,
        'path_lb' => $file,
        'updated_by' => $admin->id,
        'created_by' => $admin->id,
    ];
});
