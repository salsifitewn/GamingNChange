<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use App\Connect;

function updateImages(string $table, string $column, string $size, string $folder,string $type='.jpg')
{
    $pdo = Connect::getDB();
    $query = $pdo->query("Select $column From $table");
    while ($url = $query->fetch()[$column]) {
        $url=str_replace('.jpg',$type,$url);
        $newurl = dirname(__DIR__) . '/public/img/' . str_replace("//images.igdb.com/igdb/image/upload/t_$size/", "$folder/", $url);
        if (!file_exists($newurl)) {
            echo 'https:' . str_replace("$folder/", "//images.igdb.com/igdb/image/upload/t_$size/", $newurl);
            file_put_contents($newurl, file_get_contents('https:' . str_replace("$folder/", "//images.igdb.com/igdb/image/upload/t_$size/", $url)));
        }
    }
    $query2 = $pdo->exec("update $table set $column=replace($column,'/images.igdb.com/igdb/image/upload/t_$size/','$folder/') 
    where $column like '%//images.igdb.com/igdb/image/upload/t_$size/%'");
    if($type!=='.jpg')
    $query2 = $pdo->exec("update $table set $column=replace($column,'.jpg','$type')");

}
updateImages('games','url','cover_big','cover');
updateImages('games','url_screenshot','screenshot_big','screenshots');
updateImages('platforms','url_logo','logo_med','logo',".png");


/* $pdo = Connect::getDB();
$query = $pdo->query("Select url From games");
while ($url = $query->fetch()['url']) {
    $newurl = dirname(__DIR__) . '/public/img/' . str_replace('//images.igdb.com/igdb/image/upload/t_cover_big/', 'cover/', $url);
    if (!file_exists($newurl)) {
        echo 'https:' . str_replace('cover/', '//images.igdb.com/igdb/image/upload/t_cover_big/', $newurl);
        file_put_contents($newurl, file_get_contents('https:' . str_replace('cover/', '//images.igdb.com/igdb/image/upload/t_cover_big/', $url)));
    }
}

$query2 = $pdo->query("update games set url=replace(url,	'//images.igdb.com/igdb/image/upload/t_cover_big/','cover/') where url like '%//images.igdb.com/igdb/image/upload/t_cover_big/%'");

$query = $pdo->query("Select url_logo From platforms");
while ($url = $query->fetch()['url_logo']) {
    $newurl = dirname(__DIR__) . '/public/img/' . str_replace('//images.igdb.com/igdb/image/upload/t_logo_med/', 'logo/', $url);
    if (!file_exists($newurl)) {
        //echo 'https:'.str_replace('logo/','//images.igdb.com/igdb/image/upload/t_logo_med/',$newurl);
        file_put_contents($newurl, file_get_contents('https:' . str_replace('logo/', '//images.igdb.com/igdb/image/upload/t_logo_med/', $url)));
    }
}

$query2 = $pdo->query("update platforms set url_logo=replace(url_logo,	'//images.igdb.com/igdb/image/upload/t_logo_med/','logo/') where url_logo like '%//images.igdb.com/igdb/image/upload/t_logo_med/%'");
 */