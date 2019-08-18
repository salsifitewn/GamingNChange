<?php
//recupère les platformes manquantes

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use App\Connect;
use App\Igdb;

$pdo = Connect::getDB();
$query = $pdo->query("SELECT distinct id_platform from game_platforms except SELECT distinct id from platforms");
$platforms = [];
while ($platform = $query->fetchColumn())
    $platforms[] = $platform;
$igdb = new Igdb("665a4a7b1bcc4222453547bbcd4455f2");
$platforms = $igdb->getPlatforms($platforms);
$query = $pdo->prepare("INSERT ignore INTO `platforms` (`id`, `name`, `url_logo`) 
 values(:id,:name,:url) ");
foreach ($platforms as $platform) {
    if(!empty($platform['platform_logo']['url'])){
        $url=Igdb::getCover($platform['platform_logo']['url'],"logo_med");
    }
    $query->execute([
        'id' => $platform['id'],
        ':name' => $platform['name'],
        ':url' => $url??null
    ]);

 }
