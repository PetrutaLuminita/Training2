<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
//        'title' => $faker->title,
//        'description' => $faker->sentence,
//        'price' => $faker->numberBetween([min: 1, max: 100])
    ];
});
