<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'label' => $faker->word,
       
    ];
});
$factory->define(App\Permission::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'label' => $faker->word,
       
    ];
});

$factory->define(App\Client::class, function (Faker\Generator $faker) {
    return [
        'fullname' => $faker->name,
        'company' => $faker->company,
        'job' => $faker->word,
        'email' => $faker->email,
        'web' => $faker->url,
        'phone1' => $faker->phoneNumber,
        'phone2' => $faker->phoneNumber,
        'phone3' => $faker->phoneNumber,
        'phone4' => $faker->phoneNumber,
        'address' => $faker->address,
    ];
});
