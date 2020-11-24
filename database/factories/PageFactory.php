<?php

/** @var Factory $factory */

use App\Models\Page;
use Faker\Generator as Faker;
use \Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Page::class, function (Faker $faker) {
    $status = $faker->randomElement(['public', 'draft', 'private', 'trash']);
    $admin = Administrator::first();
    $publishedAt = $faker->dateTimeBetween('-1 days', '+30 days');
    return [
        'title_lb' => $faker->sentence(10),
        'image_lb' => $faker->imageUrl(),
        'description_lb' => $faker->sentence(50),
        'content_lb' => $faker->sentence(200),
        'status_sl' => $status,
        'published_at' => $publishedAt->format('Y-m-d'),
        'updated_by' => $admin->id,
        'created_by' => $admin->id,
    ];
});
