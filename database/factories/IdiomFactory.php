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
use App\Models\Idiom;

$factory->define(Idiom::class, function (Generator $faker) {
    return [
        'text' => $faker->word,
        'root' => random_int(1, 100),
        'word' => random_int(1, 50)
    ];
});
