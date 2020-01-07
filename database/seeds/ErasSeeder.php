<?php

use App\Models\Era;
use Illuminate\Database\Seeder;

class ErasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eras = [
            [
                "id" => 1,
                "gregorianFrom" => 169,
                "gregorianTo" => 621,
                "hijriFrom" => -480,
                "hijriTo" => 1,
                "name" => "Before Islam",
                "name_ar" => "جاهلي",
                "name_en" => "Before Islam"
            ],
            [
                "id" => 2,
                "gregorianFrom" => 622,
                "gregorianTo" => 748,
                "hijriFrom" => 1,
                "hijriTo" => 131,
                "name" => "Islam",
                "name_ar" => "إسلامي",
                "name_en" => "Islam"
            ],
            [
                "id" => 3,
                "gregorianFrom" => 749,
                "gregorianTo" => 1257,
                "hijriFrom" => 132,
                "hijriTo" => 655,
                "name" => "Abbasi",
                "name_ar" => "عباسي",
                "name_en" => "Abbasi"
            ],
            [
                "id" => 4,
                "gregorianFrom" => 1258,
                "gregorianTo" => 1804,
                "hijriFrom" => 656,
                "hijriTo" => 1219,
                "name" => "Mini States and Emirates",
                "name_ar" => "دول وإمارات",
                "name_en" => "Mini States and Emirates"
            ],
            [
                "id" => 5,
                "gregorianFrom" => 1805,
                "gregorianTo" => 2018,
                "hijriFrom" => 1220,
                "hijriTo" => 1440,
                "name" => "Recent",
                "name_ar" => "حديث",
                "name_en" => "Recent"
            ]
        ];

        foreach ($eras as $key => $era){
            $faker = Faker\Factory::create();
            factory(Era::class)->create([
                'id'            => $era['id'],
                'gregorianFrom' => $era['gregorianFrom'],
                'gregorianTo'   => $era['gregorianTo'],
                'hijriFrom'     => $era['hijriFrom'],
                'hijriTo'       => $era['hijriTo'],
                'name'          => $era['name'],
                'name_ar'       => $era['name_ar'],
                'name_en'       => $era['name_en']
            ]);
        }
    }
}
