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

use App\Models\Era;
use Faker\Generator;
use App\Models\Word;
use App\Models\AdjectiveTypePattern;
use App\Models\NounAttribution;
use App\Models\NounClassPlural;
use App\Models\NounMinimize;
use App\Models\NounSex;
use App\Models\NounSexHow;
use App\Models\NounType;
use App\Models\VerbPhonologicalRule;
use App\Models\VerbSyntaxicalRule;
use App\Models\Pattern;
use App\Models\Verb;
use App\Models\Noun;
use App\Models\Adjective;
use App\Models\Infinitive;


$factory->define(AdjectiveTypePattern::class, function (Generator $faker) {
    return [
        'text' => $faker->word,
        'ala_id' => sprintf("AdjectiveTypePattern_%s", random_int(1, 1000)),
    ];
});
$factory->define(NounAttribution::class, function (Generator $faker) {
    return [
        'text' => $faker->word,
        'ala_id' => sprintf("NounAttribution_%s", random_int(1, 1000)),
    ];
});
$factory->define(NounClassPlural::class, function (Generator $faker) {
    return [
        'text' => $faker->word,
        'ala_id' => sprintf("NounClassPlural_%s", random_int(1, 1000)),
    ];
});
$factory->define(NounMinimize::class, function (Generator $faker) {
    return [
        'text' => $faker->word,
        'ala_id' => sprintf("NounMinimize_%s", random_int(1, 1000)),
    ];
});
$factory->define(NounSex::class, function (Generator $faker) {
    return [
        'text' => $faker->word,
        'ala_id' => sprintf("NounSex_%s", random_int(1, 1000)),
    ];
});
$factory->define(NounSexHow::class, function (Generator $faker) {
    return [
        'text' => $faker->word,
        'ala_id' => sprintf("NounSexHow_%s", random_int(1, 1000)),
    ];
});
$factory->define(NounType::class, function (Generator $faker) {
    return [
        'text' => $faker->word,
        'ala_id' => sprintf("NounType_%s", random_int(1, 1000)),
    ];
});
$factory->define(VerbPhonologicalRule::class, function (Generator $faker) {
    return [
        'text' => $faker->word,
        'ala_id' => sprintf("VerbPhonologicalRule_%s", random_int(1, 1000)),
    ];
});
$factory->define(VerbSyntaxicalRule::class, function (Generator $faker) {
    return [
        'text' => $faker->word,
        'ala_id' => sprintf("VerbSyntaxicalRule_%s", random_int(1, 1000)),
    ];
});
$factory->define(Pattern::class, function (Generator $faker) {
    return [
        'text'       => $faker->word
    ];
});

$factory->define(Era::class, function (Generator $generator) {
    return [];
});

$factory->define(Verb::class, function (Generator $faker) {
    return [
        'pattern_id' => random_int(1, 20),
        'syntaxical_rule_id' => random_int(1, 20),
        'phonological_rule_id' => random_int(1, 20),
    ];
});

$factory->define(Noun::class, function (Generator $faker) {
    return [
        'pattern_id' => random_int(1, 20),
        'pattern_plural_id' => random_int(1, 20),
        'type_id' => random_int(1, 20),
        'plural' => $faker->word,
        'class_plural_id' => random_int(1, 20),
        'the_with_noun' => $faker->word,
        'sex_id' => random_int(1, 20),
        'sex_how_id' => random_int(1, 20),
        'dual_male' => $faker->word,
        'dual_female' => $faker->word,
        'attribution_id' => random_int(1, 20),
        'minimize_id' => random_int(1, 20),
        'attribution_text' => $faker->word,
        'minimize_text' => $faker->word,
    ];
});

$factory->define(Adjective::class, function (Generator $faker) {
    return [
        'adjective_pattern_id' => random_int(1, 20),
        'type_pattern_id' => random_int(1, 20),
        'past_participle' => $faker->word,
        'pattern_past_participle_id' => random_int(1, 20),
        'assimilated' => $faker->word,
        'pattern_assimilated_id' => random_int(1, 20),
        'mobalagha' => $faker->word,
        'pattern_mobalagha_id' => random_int(1, 20),
        'comperative' => $faker->word,
        'pattern_comperative_id' => random_int(1, 20),
        'period_participle' => $faker->word,
        'pattern_period_participle_id' => random_int(1, 20),
        'place_participle' => $faker->word,
        'pattern_place_participle_id' => random_int(1, 20),
        'machine_participle' => $faker->word,
        'pattern_machine_participle_id' => random_int(1, 20),
        'verb' => $faker->word,
        'pattern_verb_id' => random_int(1, 20),
    ];
});

$factory->define(Infinitive::class, function (Generator $faker) {
    return [
        'pattern_id' => random_int(1, 20),
        'pattern_verb_id' => random_int(1, 20),
        'verb' => $faker->word,
        'hayaah' => $faker->word,
        'pattern_hayaah_id' => random_int(1, 20),
        'meme' => $faker->word,
        'pattern_meme_id' => random_int(1, 20),
        'making' => $faker->word,
        'pattern_making_id' => random_int(1, 20),
        'inf_time' => $faker->word,
        'pattern_time_id' => random_int(1, 20),
    ];
});

$factory->define(Word::class, function (Generator $faker) {

    $verbId = $nounId = $adjectiveId = $infinitiveId = null;
    $randomChoice = random_int(1, 4);
    switch($randomChoice){
        case 1:
            $nounId = factory(Noun::class)->create()->id;
            break;
        case 2:
            $verbId = factory(Verb::class)->create()->id;
            break;
        case 3:
            $adjectiveId = factory(Adjective::class)->create()->id;
            break;
        case 4:
            $infinitiveId = factory(Infinitive::class)->create()->id;
            break;
    }

    return [
        'text' => $faker->word,
        'root' => random_int(1, 100),
        'type' => $randomChoice,
        'verb_id' => $verbId,
        'noun_id' =>  $nounId,
        'adjective_id' => $adjectiveId,
        'infinitive_id' => $infinitiveId,
    ];
});
