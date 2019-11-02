<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use App\Connect;
use App\Igdb;

$igdb = new Igdb("665a4a7b1bcc4222453547bbcd4455f2");
$games = $igdb->getLastGames();
$pdo = Connect::getDB();
$pdo->beginTransaction();
$query = $pdo->prepare("INSERT Ignore  INTO `games` (id, `name`, `first_release_year`, `summary`, `score`, `created_at`, `url`,`url_screenshot`) 
 values(:id,:name,:first_released_year,:summary,:score,now(),:url,:url_screenshot) ");
$query2 = $pdo->prepare("INSERT Ignore INTO `game_platforms` (`id_game`, `id_platform`, `released_year`) 
 values(:id_game,:id_platform,:released_year) ");
$query3 = $pdo->prepare("INSERT ignore  INTO `game_companies` (`name`, `id_game`, `publisher`, `developer`) 
 values(:name,:id_game,:publisher,:developer) ");
foreach ($games as $game) {
    //echo $game['screenshots'][0]['url'];
    if (!is_null($game['first_release_date']) && !is_null($game['screenshots'][0]['url'])) {

        $query->execute([
            'id' => $game['id'],
            ':name' => $game['name'],
            ':first_released_year' => date("Y", $game['first_release_date']) ?? null,
            ':summary' => $game['summary'],
            ':score' => $game['rating'],
            ':url' => Igdb::getCover($game['cover']['url'], "cover_big"),
            ':url_screenshot' => Igdb::getCover($game['screenshots'][0]['url'] ?? 'NULL', "screenshot_big")

        ]);
        if (isset($game['platforms'])) {
            foreach ($game['platforms'] as $platform) {
                $game_platform_release_year = null;
                foreach ($game['release_dates'] as $date) {
                    if ($date['platform'] == $platform['id'] && (is_null($game_platform_release_year) || $game_platform_release_year < $date['date']))
                        $game_platform_release_year = $date['date'];
                }
                $query2->execute([
                    ':id_game' => $game['id'],
                    ':id_platform' => $platform['id'],
                    ':released_year' => date("Y", $game_platform_release_year) ?? null
                ]);
            }
        }
        if (isset($game['involved_companies'])) {

            foreach ($game['involved_companies'] as $company) {
                $query3->execute([
                    ':name' => $company['company']['name'],
                    ':id_game' => $game['id'],
                    ':publisher' => (int) $company['publisher'] ?? 0,
                    ':developer' => (int) $company['developer'] ?? 0

                ]);
            }
        }
    }
}
$pdo->commit();
/* $query = $pdo->query("select distinct publisher_id from games");
$datas = $query->fetchall(PDO::FETCH_COLUMN);
$listet = implode(',', $datas); */
