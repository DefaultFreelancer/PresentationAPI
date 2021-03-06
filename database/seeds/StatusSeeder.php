<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['New', 'Draft', 'Needs review', 'Approved'];
        foreach ($statuses as $status){
            Status::create([
                'name' => $status
            ]);
        }
    }
}
