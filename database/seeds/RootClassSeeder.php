<?php

use Illuminate\Database\Seeder;

use App\Models\RootClass;

class RootClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(RootClass::class, 10)->create();
    }
}
