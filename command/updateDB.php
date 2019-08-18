<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
//use App\Igdb;
use App\Connect;
//require_once '../class/connection.php';

$faker = \Faker\Factory::create('fr_FR');

$pdo=Connect::getDB();
$pdo->exec('TRUNCATE TABLE Games');


// à changer avec des vraies données
for($i=0;$i<50;$i++){
    $pdo->exec("INSERT INTO `games` (`id`, `name`, `first_release_year`, `publisher_id`, `developper_id`, `summary`, `score`, `created_at`, `franchise`, `dlc_game`) "
    . "VALUES (NULL, 'jeu #$i', '{$faker->date}', '{$faker->randomNumber(2)}', '{$faker->randomNumber(2)}', '{$faker->text(100)}', '{$faker->randomDigit}', CURRENT_TIMESTAMP, '{$faker->randomNumber(2)}', '{$faker->randomNumber(3)}')");

}

//