<?php

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Notification::class, 150)->create();
    }
}
