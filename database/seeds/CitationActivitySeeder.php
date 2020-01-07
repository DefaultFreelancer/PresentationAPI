<?php

use Illuminate\Database\Seeder;
use App\Models\CitationActivity;

class CitationActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CitationActivity::class, 100)->create();
    }
}
