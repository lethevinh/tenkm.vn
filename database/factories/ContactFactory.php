<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contact;
use Faker\Generator as Faker;
use \Dcat\Admin\Models\Administrator;

$factory->define(Contact::class, function (Faker $faker) {
   return [
        'title_lb' => $faker->sentence(4),
        'name_lb' => $faker->sentence(4),
        'email_lb' => $faker->email,
        'content_lb' => $faker->sentence(4),
        'status_sl' => 'new',
    ];
});
