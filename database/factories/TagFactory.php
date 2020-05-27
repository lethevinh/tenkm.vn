<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Tag;
use Faker\Generator as Faker;
use \Dcat\Admin\Models\Administrator;

$factory->define(Tag::class, function (Faker $faker) {
    $status = $faker->randomElement(['public', 'draft', 'private', 'trash']);
    $admin = Administrator::first();
    return [
        'title_lb' => 'Tag ' . $faker->sentence(2),
        'image_lb' => $faker->imageUrl(),
        'description_lb' => $faker->sentence(100),
        'content_lb' => $faker->text(200),
        'type_lb' => 'post',
        'status_sl' => $status,
        'updated_by' => $admin->id,
        'created_by' => $admin->id,
    ];
});
