<?php

use Faker\Generator as Faker;
use App\MicrositeInfo;
use App\Game;

$factory->define(MicrositeInfo::class, function (Faker $faker) {
    return [
        'game_id' => @Game::inRandomOrder()->first()['id'],
        'template_id' => 1,
        'hostname' => $faker->domainName,
        'meta_keywords' => implode(',', $faker->words(10, false)),
        'meta_description' => $faker->text(200),
        'home_title' => $faker->sentence(4)
    ];
});
