<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use \App\Models\Menu;
use Faker\Generator as Faker;
use Dcat\Admin\Models\Administrator;

$factory->define(Menu::class, function (Faker $faker) {
    $status = $faker->randomElement(['public', 'draft', 'private', 'trash']);
    $admin = Administrator::first();
    $publishedAt = $faker->dateTimeBetween('-1 days', '+30 days');
    return [
        'title_lb' => $faker->sentence(4),
        'order_nb' => $faker->numberBetween(0,10),
        'media_lb' => $faker->imageUrl(),
        'content_lb' => $faker->text(200),
        'status_sl' => $status,
        'parent_id' => $faker->numberBetween(0,2),
        'published_at' => $publishedAt->format('Y-m-d'),
        'updated_by' => $admin->id,
        'created_by' => $admin->id,
    ];
});
