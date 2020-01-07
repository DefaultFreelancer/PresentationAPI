<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('word_types')->insert([
            'code' => 'noun',
            'name' => 'Noun',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('word_types')->insert([
            'code' => 'verb',
            'name' => 'Verb',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('word_types')->insert([
            'code' => 'adje',
            'name' => 'Adjective',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('word_types')->insert([
            'code' => 'infi',
            'name' => 'Infinitive',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
