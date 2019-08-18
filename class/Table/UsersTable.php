<?php
namespace App\Table;
use App\Connect;


class Userstable extends Table
{


public static function getUser($id){
    $pdo = Connect::getDb();
    return $pdo->query("Select * from users where id=$id")->fetch(\PDO::FETCH_CLASS,'App\Model\User');
    
}


    

  
}
