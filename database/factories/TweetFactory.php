<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tweet;
use Faker\Generator as Faker;

$factory->define(Tweet::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence(),
        'created_at' => $faker->dateTimeBetween($startDate = '2020-8-25 00:00:49', $endDate = 'now', null)
    ];
});
