<?php

namespace App\Table;

use App\Connect;

class PlatformTable
{


    public static function getPlat(array $games)
    {
        $pdo = Connect::getDb();
        $query = $pdo->query("Select * from users where id=$id");
        $query->setFetchMode(\PDO::FETCH_CLASS, 'App\Model\User');
        return $query->fetch();
    }
    public static function getPlatform(int $platformid){
        $pdo = Connect::getDb();
        $query = $pdo->query("Select * from platforms where id=$platformid");
        return $query->fetchall();
    }
    public static function getAllPlatforms(){
        $pdo = Connect::getDb();
        $query = $pdo->query("SELECT DISTINCT * from platforms ORDER by name");
        return $query->fetchall();
    }

    public static function getPlatformName(int $platformid)
    {
        $pdo = Connect::getDb();
        return $pdo->query("SELECT name from platforms where id=$platformid")->fetch()[0];
    }

    public static function getPlatformImg(int $platformid)
    {
        $pdo = Connect::getDb();
        return $pdo->query("SELECT url_logo from platforms where id=$platformid")->fetch()[0];
    }

    public static function updatePlatformTable()
    {
        $pdo = Connect::getDB();
        $query = $pdo->query("SELECT distinct id_platform from game_platforms except SELECT distinct id from platforms");
        $platforms = [];
        while ($platform = $query->fetchColumn())
            $platforms[] = $platform;
        $igdb = new \App\Igdb("665a4a7b1bcc4222453547bbcd4455f2");
        $platforms = $igdb->getPlatforms($platforms);
        $query = $pdo->prepare("INSERT ignore INTO `platforms` (`id`, `name`, `url_logo`) 
 values(:id,:name,:url) ");
        foreach ($platforms as $platform) {
            if (!empty($platform['platform_logo']['url'])) {
                $url = Igdb::getCover($platform['platform_logo']['url'], "logo_med");
            }
            $query->execute([
                'id' => $platform['id'],
                ':name' => $platform['name'],
                ':url' => $url ?? null
            ]);
        }
    }
}
