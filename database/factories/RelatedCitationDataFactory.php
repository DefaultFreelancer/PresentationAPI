<?php

use App\Models\NounNature;
use App\Models\NounNatureCitation;
use App\Models\ScientificDomain;
use App\Models\ScientificDomainCitation;
use App\Models\Source;
use Faker\Generator;

$factory->define(ScientificDomain::class, function (Generator $faker) {
    return [
        'model' => $faker->word
    ];
});

$factory->define(Source::class, function (Generator $faker) {
    return [
        'source' => $faker->word
    ];
});

$factory->define(NounNature::class, function (Generator $faker) {
    return [
        'nature' => $faker->word
    ];
});

$factory->define(ScientificDomainCitation::class, function (Generator $faker) {
    return [
        'citation_id' => random_int(1,10),
        'domain_id'   => random_int(1,10)
    ];
});

$factory->define(NounNatureCitation::class, function (Generator $faker) {
    return [
        'citation_id' => random_int(1,10),
        'nature_id'   => random_int(1,4)
    ];
});






