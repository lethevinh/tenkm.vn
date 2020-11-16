<?php

/** @var Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;
use \Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Factory;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    $status = $faker->randomElement(array_keys(Post::STATUS));
    $admin = Administrator::first();
    $publishedAt = $faker->dateTimeBetween('-30 days', '-1 days');
    $validatedAt = $faker->dateTimeBetween('+100 days', '+300 days');
    $listImages = ['1', '2', '3', '4', '6', '6', '7', '8', '9'];
    $image = '/images/dummy/products/' . $faker->randomElement($listImages) . '.jpg';
    $image1 = '/images/dummy/products/' . $faker->randomElement($listImages) . '.jpg';
    $image2 = '/images/dummy/products/' . $faker->randomElement($listImages) . '.jpg';
    $image3 = '/images/dummy/products/' . $faker->randomElement($listImages) . '.jpg';
    $image4 = '/images/dummy/products/' . $faker->randomElement($listImages) . '.jpg';
    $galleries = implode(',', [url($image1),url($image2),url($image3),url($image4)]);
    return [
        'title_lb' => 'Product ' . $faker->sentence(8),
        'image_lb' => url($image),
        'gallery_lb' => $galleries,
        'description_lb' => $faker->sentence(50),
        'content_lb' => $faker->sentence(200),
        'language_lb' => 'vi',
        'status_sl' => $status,
        'price_fl' => $faker->randomFloat(100000000, 500000),
        'price_sale_fl' => $faker->randomFloat(1000000, 50000),
        'bedroom_nb' => $faker->randomFloat(2, 5),
        'bathroom_nb' => $faker->randomFloat(2, 5),
        'area_nb' => $faker->randomFloat(100, 500),
        'updated_by' => $admin->id,
        'created_by' => $admin->id,
        'validated_at' => $validatedAt,
        'published_at' => $publishedAt,
    ];
});
