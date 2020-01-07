<?php

use Illuminate\Database\Seeder;
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

class CodeListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(AdjectiveTypePattern::class, 20)->create();
        factory(NounAttribution::class, 20)->create();
        factory(NounClassPlural::class, 20)->create();
        factory(NounMinimize::class, 20)->create();
        factory(NounSex::class, 20)->create();
        factory(NounSexHow::class, 20)->create();
        factory(NounType::class, 20)->create();
        factory(VerbPhonologicalRule::class, 20)->create();
        factory(VerbSyntaxicalRule::class, 20)->create();
        factory(Pattern::class, 20)->create();
    }
}