<?php

use App\Models\ApproximateDate;
use Illuminate\Database\Seeder;

class ApproximateDatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApproximateDate::create('20 Hijri Sample AA',20,20);
        ApproximateDate::create('120 Hijri Sample BB',120,120);
        ApproximateDate::create('140 Hijri Sample CC',140,140);
        ApproximateDate::create('155 Hijri Sample DD',155,155);
        ApproximateDate::create('161 Hijri Sample EE',161,161);
        ApproximateDate::create('176 Hijri Sample FF',176,176);
    }
}
