<?php

use Faker\Generator;
use App\Models\Notification;


$factory->define(Notification::class, function (Generator $faker) {

    $dt = $faker->dateTimeBetween('-2 month', 'now', 'UTC');

    return [
        'recipient' => random_int(1, 4),
        'subject' => $faker->text(10),
        'message' => $faker->text,
        'target' => null,
        'user' => random_int(90, 104),
        'created_at' => $dt,
        'updated_at' => $dt,
    ];
});
