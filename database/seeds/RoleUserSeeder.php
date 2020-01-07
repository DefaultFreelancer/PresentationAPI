<?php

use Illuminate\Database\Seeder;
use App\Models\RoleUser;
use App\Models\User;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$users = User::all()->take(10);
	    foreach (range(1,3) as $role) {
	        foreach ($users as $user) {
	        	RoleUser::create([
	        		'user_id' => $user->id,
	        		'role_id' => $role
	        	]);                
	        }

	    }   
    }
}
