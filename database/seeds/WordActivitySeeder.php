<?php

use Illuminate\Database\Seeder;
use App\Models\WordActivity;

class WordActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(WordActivity::class, 100)->create();
    }
}
