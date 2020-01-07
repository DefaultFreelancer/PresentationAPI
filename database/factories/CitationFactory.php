<?php


use App\Models\Citation;
use Faker\Generator;
use Illuminate\Support\Facades\DB;

$factory->define(Citation::class, function (Generator $faker) {

    $dateGregorian = $faker->date('Y-m-d');
    $dateHijri = \GeniusTS\HijriDate\Hijri::convertToHijri($dateGregorian);

    $date = DB::table('eras')->where('hijriFrom' , '<' , $dateHijri->format('Y'))->where('hijriTo', '>', $dateHijri->format('Y'))->first();


    return [
        'word'              => random_int(1,10),
        'citation'          => $faker->word,
        'source'            => random_int(1,10),
        'gregorian_date_from' => $dateGregorian,
        'gregorian_date_to'   => $dateGregorian,
        'hijri_date_from'     => $dateHijri->format('Y-m-d'),
        'hijri_date_to'       => $dateHijri->format('Y-m-d'),
        'approximate'       => random_int(1,5),
        'era'               => ($date ? $date->id : 1),
        'bibliographicInfo' => $faker->text,
        'meaning'           => $faker->text,
        'miReference'       => json_encode(['test' => 'test']),
        'miItem'            => random_int(1,100),
        'miPage'            => random_int(1,100)
    ];
});
