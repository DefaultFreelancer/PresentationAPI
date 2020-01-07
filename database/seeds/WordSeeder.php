<?php

use Illuminate\Database\Seeder;
use App\Models\Word;
use App\Models\Verb;
use App\Models\Noun;
use App\Models\Adjective;
use App\Models\Infinitive;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Word::class, 1000)->create();   
    }
}
