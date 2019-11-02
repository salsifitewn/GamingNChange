<?php
namespace App\Model;
use App\Connect;
use App\Helpers\Auth;

class User
{
    //FETCH::CLASS
    //id int
    //username string
    //password string
    //role  
    //email
    //createdat

    //owner U.id,U.username,C.value,C.id

    public function getGames(){
        $pdo = Connect::getDb();
        return $pdo->query("SELECT Distinct games.* from games,user_item where games.id=user_item.gameid and userid={$this->id} and quantityToSell>0")->fetchAll(\PDO::FETCH_CLASS,'App\Model\Game');
    }
    public function getGamesToSell(){
        $pdo = Connect::getDb();
        return $pdo->query("Select games.* from games,user_item where games.id=user_item.gameid and userid={$this->id} and quantityToSell>0 and valueToSell>0")->fetchAll(\PDO::FETCH_CLASS,'App\Model\Game');
    }
    public function getWishlistedGames(){
        $pdo = Connect::getDb();
        return $pdo->query("SELECT distinct games.* from games,user_item where games.id=user_item.gameid and quantityToBuy>0 and userid={$this->id} ORDER BY id")->fetchAll(\PDO::FETCH_CLASS,'App\Model\Game');
    }
    public function getWishlistedItems(){
        $pdo = Connect::getDb();
        return $pdo->query("SELECT games.* from games,user_item where games.id=user_item.gameid and quantityToBuy>0 and userid={$this->id} ORDER BY id")->fetchAll(\PDO::FETCH_CLASS,'App\Model\Item');
    }
    public function add(int $gameid, int $platformid):int{
        $pdo = Connect::getDb();
        return $pdo->exec("INSERT INTO user_item(userid,gameid,platformid,quantityToSell,valueToSell) values({$this->id},$gameid,$platformid,1,-1) 
        on duplicate key update quantityToSell=quantityToSell+1,valueToSell=-1,
            quantityToBuy=greatest((select quantityToBuy -1 from (select * from user_item) as oops where userid={$this->id} and gameid=$gameid and platformid=$platformid),0)");
    }
    public function remove(int $gameid, int $platformid):int{
        $pdo = Connect::getDb();
        $item=$pdo->query("SELECT id,valueToSell from user_item where userid={$this->id} and gameid=$gameid and platformid=$platformid and quantityToSell>0")->fetch();
        if($item['valueToSell']>0)
    return $pdo->exec("UPDATE user_item set quantityToSell=quantityToSell-1 where id={$item['id']}");
      return 0;
    } 
    public function removeFromWishlist(int $gameid, int $platformid){

    }
    public static function insertNewUser(string $username,string $password,string $email,string $adress, int $zip, string $city):int{
        $pdo = Connect::getDb();
        return $pdo->exec("INSERT INTO users(username,password,role,email,adress,zip,city,created_at) Values ('$username','$password',1,'$email','$adress','$zip','$city',now())");
    }

    /* public function addToWishlist(int $gameid,int $platformid){

    } */
    
  

 }
