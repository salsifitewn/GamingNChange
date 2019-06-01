<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
use App\Connect;

$igdb = new \App\Igdb("665a4a7b1bcc4222453547bbcd4455f2");
$games = $igdb->getLastGames();

$pdo = Connect::db_connect();
 $query = $pdo->prepare("Replace  INTO `Games` (id, `name`, `first_release_year`, `publisher_id`, `developper_id`, `summary`, `score`, `created_at`, `url`) 
 values(:id,:name,from_unixtime(:firstreleaseyear),:publisherid,:developperid,:summary,:score,now(),:url) ");

foreach ($games as $game) {
    
    $query->execute([
        'id'=>$game['id'],
        ':name' => $game['name'],
        ':firstreleaseyear' =>$game['first_release_date']??null ,
        ':publisherid'=>$game['involved_companies'][0],
        ':developperid'=>$game['involved_companies'][0],
        ':summary' => $game['summary'],
        ':score' => $game['rating'],
        ':url' => \App\Igdb::getCover($game['cover']['url'])

    ]);
} 
$query = $pdo->query("select distinct publisher_id from games");
$datas=$query->fetchall(PDO::FETCH_COLUMN);
$listet=implode(',',$datas);

