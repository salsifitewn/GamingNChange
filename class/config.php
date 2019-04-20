<?php


    $jsonStr = file_get_contents(dirname(__DIR__) .DIRECTORY_SEPARATOR ."config.json");
    $config = json_decode($jsonStr,true);
    define("IGDB_APIKEY", $config['igdb_api_key']);  