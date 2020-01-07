<?php

use App\Models\Notification;
use Faker\Generator;
use App\Models\User;
use App\Models\Country;
use App\Models\Role;
use App\Models\Institution;
use App\Models\RoleUser;
use Illuminate\Support\Facades\DB;

$factory->define(Country::class, function (Generator $faker){
    return [
        'name' => $faker->country
    ];
});

$factory->define(Role::class, function (Generator $faker){
    $roles = ['User', 'Admin', 'Publisher', 'Monitoring',
        'Updater', 'Security', 'Management', 'Collaborator', 'Communication'];

    return [
        'name' => $faker->randomElement($roles)
    ];
});

$factory->define(Institution::class, function (Generator $faker){
    return [
        'name' => $faker->company
    ];
});

$factory->define(User::class, function (Generator $faker) {
    return [
        'name'          => $faker->name,
        'email'         => $faker->email,
        'password'      => 'NONE', // password_hash('dev', PASSWORD_BCRYPT, ['cost' => 14]), // NONE is used ot make it faster. We don't need passwords for auto users
        'phoneNumber'   => $faker->phoneNumber,
        'description'   => $faker->text,
        'status'        => random_int(0, 1),
        'country'       => random_int(1, 10),
        'institution'   => random_int(1, 10)
    ];
});

