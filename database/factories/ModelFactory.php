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

$factory->define(App\Model\UserModel::class, function (Faker\Generator $faker) {
    //load_helper('Password');

    return [
        'nickname' => $faker->name,
        //'email' => $faker->unique()->safeEmail,
        //'password' => create_password(rand(000001,999999),$salt),
        //'salt' => $salt,
        //'sex' => $faker->boolean()
    ];
});

$factory->define(App\Model\User2Model::class, function (Faker\Generator $faker) {
    //load_helper('Password');

    return [
        'nickname' => $faker->name,
        //'email' => $faker->unique()->safeEmail,
        //'password' => create_password(rand(000001,999999),$salt),
        //'salt' => $salt,
        //'sex' => $faker->boolean()
    ];
});
