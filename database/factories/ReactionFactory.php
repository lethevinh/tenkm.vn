<?php

/** @var Factory $factory */

use App\Models\Reaction;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Reaction::class, function (Faker $faker) {
    return [
        'title_lb' => 'Reaction ' . $faker->sentence(2),
        'image_lb' => $faker->imageUrl(),
        'description_lb' => $faker->sentence(100),
        'content_lb' => $faker->text(200),
    ];
});
