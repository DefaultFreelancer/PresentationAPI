<?php

use App\Models\NounNatureCitation;
use Illuminate\Database\Seeder;

class NounNatureRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(NounNatureCitation::class, 100)->create();
    }
}
