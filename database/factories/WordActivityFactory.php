<?php
use Faker\Generator;
use App\Models\WordActivity;

$factory->define(WordActivity::class, function (Generator $faker) {
    return [
        'word'      => random_int(1, 50),
        'user'      => random_int(1, 100),
        'type'      => random_int(0, 2),
        'content'   => $faker->randomHtml(2,3),
        'data'      => null
    ];
});
