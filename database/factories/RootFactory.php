<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Faker\Generator;
use App\Models\Root;
use App\Models\RootClass;
//use App\Models\Pattern;

$factory->define(Root::class, function (Generator $faker) {
    return [
        'root'          => $faker->word,
        //'pattern_id'    => random_int(1, 10),
        'class_id'      => random_int(1, 10)
    ];
});

$factory->define(RootClass::class, function (Generator $faker) {
    return [
        'class'         => $faker->word
    ];
});