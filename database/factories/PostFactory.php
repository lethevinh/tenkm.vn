<?php

/** @var Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;
use \Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Post::class, function (Faker $faker) {
    $status = $faker->randomElement(array_keys(Post::STATUS));
    $admin = Administrator::first();
    $publishedAt = $faker->dateTimeBetween('-30 days', '-1 days');
    $validatedAt = $faker->dateTimeBetween('+100 days', '+300 days');
    $image = '/assets/img/dummy_blog_img-' . $faker->randomElement(['1', '2', '3']) . '.jpg';
    return [
        'title_lb' => 'Post ' . $faker->sentence(8),
        'image_lb' => url($image),
        'description_lb' => $faker->sentence(50),
        'content_lb' => $faker->sentence(200),
        'status_sl' => $status,
        'updated_by' => $admin->id,
        'created_by' => $admin->id,
        'validated_at' => $validatedAt,
        'published_at' => $publishedAt,
    ];
});
