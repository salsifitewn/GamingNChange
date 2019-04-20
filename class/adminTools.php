<?php
require_once 'config.php';
require dirname(__DIR__).DIRECTORY_SEPARATOR.'vendor/autoload.php';

use App\Igdb;

function updateGamesFromIGDB()
{
    $igdb= new Igdb(IGDB_APIKEY);
    $igdb->getLastGames();
}

updateGamesFromIGDB();
