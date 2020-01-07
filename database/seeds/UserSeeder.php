<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
          ['id' => 1, 'name' => 'John Doe',  'email' => 'john@geneza.com',     'password' => 'dev',        'status' => 1],
          ['id' => 2, 'name' => 'Dev Bug',   'email' => 'dev@geneza.com',      'password' => 'dev',        'status' => 1],
          ['id' => 3, 'name' => 'Marko',     'email' => 'marko@geneza.com',    'password' => 'markomarko', 'status' => 1],
          ['id' => 4, 'name' => 'Test Code', 'email' => 'test@geneza.com',     'password' => 'dev',        'status' => 1],
        ];

        foreach ($users as $key => $val){
            $faker = Faker\Factory::create();
            factory(User::class)->create([
                //'id'        => $val['id'],
                'name'      => $val['name'],
                'email'     => $val['email'],
                'password'  => password_hash($val['password'], PASSWORD_BCRYPT, ['cost' => 14]),
                'status'    => $val['status'],
                'phoneNumber' => $faker->phoneNumber,
                'country'   => $faker->numberBetween(1,10),
                'institution' => $faker->numberBetween(1,10)
            ]);
        }

        factory(User::class, 100)->create();

    }
}
