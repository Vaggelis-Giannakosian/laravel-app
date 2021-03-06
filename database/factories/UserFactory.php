<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'api_token' => Str::random(80),
        'remember_token' => Str::random(10),
        'is_admin' => false
    ];
});


$factory->state(User::class, 'vag',function(Faker $faker){
    return[
        'name' => 'Vagelis Giannakosian',
        'email' => 'e.giannakosian@gmail.com',
        'password' => '$2y$10$yQan4fTAJtb.U7ZEv7ZdKOxKB7QiPiw.qZH6qi4wsv/.TqmKUxG6.', // 123456789
        'is_admin' => true
    ];
});
