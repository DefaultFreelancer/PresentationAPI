<?php

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert([
            //'id'      => 1,
            'name'      => 'first',
            'parent'    => null,
            'user_id'      => random_int(1, 10),
            'review_threshold' => random_int(1, 10),
            'strict_down' => random_int(0, 1),
            'strict_up' => random_int(0, 1),
            'display_vertical' => random_int(0, 1),
            'display_open' => random_int(0, 1),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('jobs')->insert([
            //'id'      => 2,
            'name'      => 'second',
            'parent'    => 1,
            'user_id'      => random_int(1, 10),
            'review_threshold' => random_int(1, 10),
            'strict_down' => random_int(0, 1),
            'strict_up' => random_int(0, 1),
            'display_vertical' => random_int(0, 1),
            'display_open' => random_int(0, 1),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('jobs')->insert([
            //'id'      => 3,
            'name'      => 'third',
            'parent'    => 1,
            'user_id'      => random_int(1, 10),
            'review_threshold' => random_int(1, 10),
            'strict_down' => random_int(0, 1),
            'strict_up' => random_int(0, 1),
            'display_vertical' => random_int(0, 1),
            'display_open' => random_int(0, 1),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('jobs')->insert([
            //'id'      => 4,
            'name'      => 'forth',
            'parent'    => 2,
            'user_id'      => random_int(1, 10),
            'review_threshold' => random_int(1, 10),
            'strict_down' => random_int(0, 1),
            'strict_up' => random_int(0, 1),
            'display_vertical' => random_int(0, 1),
            'display_open' => random_int(0, 1),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('jobs')->insert([
            //'id'      => 5,
            'name'      => 'fifth',
            'parent'    => 3,
            'user_id'      => random_int(1, 10),
            'review_threshold' => random_int(1, 10),
            'strict_down' => random_int(0, 1),
            'strict_up' => random_int(0, 1),
            'display_vertical' => random_int(0, 1),
            'display_open' => random_int(0, 1),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('jobs')->insert([
            //'id'      => 6,
            'name'      => 'sixt',
            'parent'    => 3,
            'user_id'      => random_int(1, 10),
            'review_threshold' => random_int(1, 10),
            'strict_down' => random_int(0, 1),
            'strict_up' => random_int(0, 1),
            'display_vertical' => random_int(0, 1),
            'display_open' => random_int(0, 1),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
