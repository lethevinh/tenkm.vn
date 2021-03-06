<?php

/** @var Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;
use \Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Factory;

$factory->define(\App\Models\Project::class, function (Faker $faker) {
    $status = $faker->randomElement(array_keys(Post::STATUS));
    $admin = Administrator::first();
    $publishedAt = $faker->dateTimeBetween('-30 days', '-1 days');
    $validatedAt = $faker->dateTimeBetween('+100 days', '+300 days');
    $image = '/images/dummy/projects/' . $faker->randomElement(['1', '2', '3', '4', '5', '6']) . '.jpg';
    $galleries = implode(',', [url($image),url($image),url($image)]);
    return [
        'title_lb' => 'Project ' . $faker->sentence(8),
        'image_lb' => url($image),
        'gallery_lb' => $galleries,
        'description_lb' => $faker->sentence(50),
        'content_lb' => $faker->sentence(200),
        'status_sl' => $status,
        'price_fl' => $faker->randomFloat(100000000, 500000),
        'price_sale_fl' => $faker->randomFloat(1000000, 50000),
        'updated_by' => $admin->id,
        'created_by' => $admin->id,
        'language_lb' => 'vi',
        'validated_at' => $validatedAt,
        'published_at' => $publishedAt,
    ];
});
