<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;
use \Dcat\Admin\Models\Administrator;
use \Illuminate\Support\Str;
$factory->define(Category::class, function (Faker $faker) {
    $status = $faker->randomElement(['public', 'draft', 'private', 'trash']);
    $admin = Administrator::first();
    $publishedAt = $faker->dateTimeBetween('-1 days', '+30 days');
    $title = $faker->sentence(3);
    return [
        'title_lb' => $title,
        'image_lb' => $faker->imageUrl(),
        'description_lb' => $faker->sentence(50),
        'content_lb' => $faker->sentence(200),
        'type_lb' => 'post',
        'status_sl' => $status,
        'published_at' => $publishedAt->format('Y-m-d'),
        'updated_by' => $admin->id,
        'created_by' => $admin->id,
    ];
});
