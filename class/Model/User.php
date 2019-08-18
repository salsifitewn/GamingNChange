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
    public function getGames(){
        $pdo = Connect::getDb();
        return $pdo->query("Select games.* from games,user_collection where games.id=user_collection.gameid and userid={$this->id} and quantityToSell>0")->fetchAll(\PDO::FETCH_CLASS,'App\Model\Game');
    }

    public function getWishlistedGames(){
        $pdo = Connect::getDb();
        return $pdo->query("Select games.* from games,user_wishlist where games.id=user_wishlist.gameid and userid={$this->id} order by rank")->fetchAll(\PDO::FETCH_CLASS,'App\Model\Game');
    }

    public function add(int $gameid, int $platformid,int $value=0):int{
        $pdo = Connect::getDb();
        return $pdo->exec("INSERT INTO user_collection(userid,gameid,platformid,quantityToSell,value)  values({$this->id},$gameid,$platformid,1,$value)
        on duplicate key update quantityToSell=quantityToSell+1");
    }
   /*  public function remove(int $gameid, int $platformid,int $value):int{
        $pdo = Connect::getDb();
        $query=$pdo->query("SELECT * from user_collection where userid=$gameid and platfromid=$platformid and ")
        return $pdo->exec("INSERT into user_collection(userid,gameid,platformid,quantityToSell,value) set values($gameid,$platformid,1,$value)
        on duplicate key update quantityToSell=quantityToSell-1");
    } */

    public static function insertNewUser(string $username,string $password,string $email):int{
        $pdo = Connect::getDb();
        return $pdo->exec("INSERT INTO users(username,password,role,email,created_at) Values ('$username','$password',1,'$email',now())");
    }

    /* public function addToWishlist(int $gameid,int $platformid){

    } */
    
    public static function getUser(int $id){
        $pdo = Connect::getDb();
        $query=$pdo->query("Select * from users where id=$id");
        $query->setFetchMode(\PDO::FETCH_CLASS,'App\Model\User');
        return $query->fetch();
    }

    public function getGameValue(int $gameid,int $platformid):?int
    {
        $pdo=Connect::getDB();
        $query=$pdo->query("SELECT value from user_collection where userid={$this->id} and gameid=$gameid and platfromid=$platformid");
        return $query->fetch();
        
    }
    public  function addToBasket(){
   
        
    }
    public function getBasket(){

    }

 }
