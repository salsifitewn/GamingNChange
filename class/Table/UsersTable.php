<?php
namespace App\Table;
use App\Connect;


class UsersTable extends Table
{


public static function getUser($id){
    $pdo = Connect::getDb();
    $query=$pdo->query("Select * from users where id=$id");
    $query->setFetchMode(\PDO::FETCH_CLASS,'App\Model\User');
    return $query->fetch();
    
}


    

  
}
