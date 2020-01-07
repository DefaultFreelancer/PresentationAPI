<?php

use Illuminate\Database\Seeder;

use App\Models\Root;

class RootSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Root::class, 100)->create();
    }
}
