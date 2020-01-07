<?php


use App\Models\CitationActivity;
use Faker\Generator;

$factory->define(CitationActivity::class, function (Generator $faker) {
    return [
        'citation' => random_int(1, 100),
        'user'      => random_int(1, 100),
        'type'      => random_int(0, 2),
        'content'   => $faker->randomHtml(2,3),
        'data'      => null
    ];
});