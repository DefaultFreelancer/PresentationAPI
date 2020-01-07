<?php

use App\Models\Citation;
use Illuminate\Database\Seeder;

class CitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Citation::class, 100)->create();
    }
}
