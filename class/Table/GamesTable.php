<?php

namespace App\Table;
use App\Connect;

class GamesTable extends Table
{
    public static function addGames(array $igdbdatagames)
    {
        $pdo = \App\Connect::getDB();
        $pdo->beginTransaction();
        $query = $pdo->prepare(
            "Replace  INTO `games` (id, `name`, `first_release_year`, `summary`, `score`, `created_at`, `url`,`url_screenshot`) 
            values(:id,:name,:first_released_year,:summary,:score,now(),:url,:url_screenshot) "
        );
        $query2 = $pdo->prepare("INSERT Ignore INTO `game_platforms` (`id_game`, `id_platform`, `released_year`) 
 values(:id_game,:id_platform,:released_year) ");
        $query3 = $pdo->prepare("INSERT ignore  INTO `game_companies` (`name`, `id_game`, `publisher`, `developer`) 
 values(:name,:id_game,:publisher,:developer) ");
        foreach ($igdbdatagames as $game) {
            //check foreign key();
            $query->execute([
                'id' => $game['id'],
                ':name' => $game['name'],
                ':first_released_year' => date("Y", $game['first_release_date']) ?? null,
                ':summary' => $game['summary'],
                ':score' => $game['rating'] ?? null,
                ':url' => \App\Igdb::getCover($game['cover']['url'], "cover_big"),
                ':url_screenshot' => \App\Igdb::getCover($game['screenshots'][0]['url'], "screenshot_big")

            ]);
            foreach ($game['platforms'] as $platform) {

                $game_platform_release_year = null;
                foreach ($game['release_dates'] as $date) {
                    if ($date['platform'] == $platform['id'] && (is_null($game_platform_release_year) || $game_platform_release_year < $date['date']))
                        $game_platform_release_year = $date['date']??null;
                }
                $query2->execute([
                    ':id_game' => $game['id'],
                    ':id_platform' => $platform['id'],
                    ':released_year' => date("Y", $game_platform_release_year) ?? null
                ]);
            }
            foreach ($game['involved_companies'] as $company) {
                $query3->execute([
                    ':name' => $company['company']['name'],
                    ':id_game' => $game['id'],
                    ':publisher' => (int) $company['publisher'] ?? 0,
                    ':developer' => (int) $company['developer'] ?? 0

                ]);
            }
        }
        $query = $pdo->query("SELECT url FROM games");
        while ($url = $query->fetch()['url']) {
            $newurl = dirname(dirname(__DIR__)) . '/public/img/' . str_replace('//images.igdb.com/igdb/image/upload/t_cover_big/', 'cover/', $url);
            if (!file_exists($newurl)) {
                //echo 'https:' . str_replace('cover/', '//images.igdb.com/igdb/image/upload/t_cover_big/', $newurl);
                file_put_contents($newurl, file_get_contents('https:' . str_replace('cover/', '//images.igdb.com/igdb/image/upload/t_cover_big/', $url)));
            }
        }
        $query2 = $pdo->query("update games set url=replace(url,	'//images.igdb.com/igdb/image/upload/t_cover_big/','cover/') where url like '%//images.igdb.com/igdb/image/upload/t_cover_big/%'");
        
        $query = $pdo->query("SELECT url_screenshot FROM games where url_screenshot like '%igdb%'");
        while ($url = $query->fetch()['url_screenshot']) {
            $newurl = dirname(dirname(__DIR__)) . '/public/img/' . str_replace('//images.igdb.com/igdb/image/upload/t_screenshot_big/', '/screenshots/', $url);
           // echo $newurl.'\n';
            if (!file_exists($newurl)) {
                //echo 'https:' . str_replace('cover/', '//images.igdb.com/igdb/image/upload/t_cover_big/', $newurl);
                //dd( 'https:' . str_replace('/screenshots/', '//images.igdb.com/igdb/image/upload/t_screenshot_big', $url));
                file_put_contents($newurl, file_get_contents('https:' . str_replace('/screenshots/', '//images.igdb.com/igdb/image/upload/t_screenshot_big', $url)));
            }
        }
        $query2 = $pdo->query("update games set url_screenshot=replace(url_screenshot,	'//images.igdb.com/igdb/image/upload/t_screenshot_big/','screenshots/') where url_screenshot like '%//images.igdb.com/igdb/image/upload/t_screenshot_big/%'");
        $pdo->commit();
    }

    public function getGames()
    {
        $pdo = App\Connect::getDB();
        $query = $pdo->query("select * from games");
        $games = $query->fetchAll(pdo::FETCH_ASSOC);
    }
    public static function getGame($gameid)
    {
        $pdo = Connect::getDb();
        $query=$pdo->query("Select * from games where id=$gameid");
        $query->setFetchMode(\PDO::FETCH_CLASS,'App\Model\Game');
        return $query->fetch();
    }
}
