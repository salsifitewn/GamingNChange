<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use App\App;
$app=App::getInstance();
var_dump($app->getTable('Users'));