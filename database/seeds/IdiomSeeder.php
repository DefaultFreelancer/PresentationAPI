<?php

use Illuminate\Database\Seeder;
use App\Models\Idiom;

class IdiomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Idiom::class, 50)->create();
    }
}
