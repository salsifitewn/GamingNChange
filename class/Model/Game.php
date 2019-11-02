<?php

namespace App\Model;

use App\Connect;

class Game
{
    //pdo::fetch_class
    //id
    //name
    //first release date
    //summary
    //score
    //createdat
    //url
    //urlscreenshot

    public $platformid;
    public $value;

    public function getImage($url): ?string
    { 
        
    }

    public function getPlatforms(): ?array
    { 
        $pdo = Connect::getDB();
        $query = $pdo->query("SELECT platforms.*  from game_platforms,platforms where game_platforms.id_platform=platforms.id and game_platforms.id_game={$this->id}");
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getwishlistedPlatforms(): ?array
    { 
        $pdo = Connect::getDB();
        $query = $pdo->query("SELECT platforms.*  from user_item,platforms where user_item.platformid=platforms.id and user_item.gameid={$this->id} and quantityToBuy>0");
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getOwnedPlatforms(): ?array
    { 
        $pdo = Connect::getDB();
        $query = $pdo->query("SELECT platforms.*  from user_item,platforms where user_item.platformid=platforms.id and user_item.gameid={$this->id} and quantityToSell>0");
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getPublishers(): ?array
    {
        $pdo = Connect::getDB();
        $query = $pdo->query("SELECT game_companies.name from games,game_companies where games.id=game_companies.id_game and publisher=1 and games.id={$this->id}");
        $publishers=[];
        while($res=$query->fetchColumn())
        $publishers[] = $res;
        return $publishers;
    }
    public function getDevelopers(): ?array
    {
        $pdo = Connect::getDB();
        $query = $pdo->query("SELECT game_companies.name from games,game_companies where games.id=game_companies.id_game and developer=1 and games.id={$this->id}");
        $developers =[];
        while($res=$query->fetchColumn())
        $developers[] = $res;
        return $developers;
    }
    public function getOwners($platform)
    {
        $pdo = Connect::getDB();
        $query = $pdo->query("SELECT U.id,U.username,C.valueToSell,C.id as itemid FROM user_item C,users U WHERE C.quantityToSell > 0 and C.userid=U.id and C.platformid=$platform and C.gameid={$this->id} order by C.valueToSell");
        return $query->fetchall(\PDO::FETCH_CLASS,'App\Model\User');    
    }

    

}
