<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use App\Connect;

$pdo=Connect::db_connect();
$query=$pdo->query("Select url From games");
while ($url=$query->fetch()['url']){
    $newurl=dirname(__DIR__).'/public/img/' . str_replace('//images.igdb.com/igdb/image/upload/t_cover_big/','cover/',$url);
    if(!$newurl===$url)
    file_put_contents($newurl,file_get_contents('https:'.$url));
}

$query2=$pdo->query("update games set url=replace(url,	'//images.igdb.com/igdb/image/upload/t_cover_big/','cover/') where url like '%//images.igdb.com/igdb/image/upload/t_cover_big/%'");
