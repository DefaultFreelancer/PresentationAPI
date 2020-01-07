<?php

use App\Models\ScientificDomainCitation;
use Illuminate\Database\Seeder;

class ScientificDomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ScientificDomainCitation::class, 100)->create();
    }
}
