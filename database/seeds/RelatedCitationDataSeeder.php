<?php


use App\Models\NounNature;
use App\Models\ScientificDomain;
use App\Models\Source;
use Illuminate\Database\Seeder;

class RelatedCitationDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ScientificDomain::class, 10)->create();
        factory(Source::class, 10)->create();
        factory(NounNature::class, 4)->create();
    }
}
