<?php

namespace App\Table;
use App\Connect;

class TransactionsTable{

public static function getPurchases($userid){
    $pdo = Connect::getDb();
    $query=$pdo->query("SELECT transactions.*,userid,platformid,gameid  from transactions,user_item where olditemid=user_item.id and buyerid=$userid");
    return $query->fetchall(\PDO::FETCH_CLASS,'App\Model\Transaction');   
    
}
public static function getSales($userid){
    $pdo = Connect::getDb();
    $query=$pdo->query("SELECT transactions.*,userid,platformid,gameid from transactions,user_item where olditemid=user_item.id and userid=$userid");
    return $query->fetchall(\PDO::FETCH_CLASS,'App\Model\Transaction');   
    
}
public static function getTransaction($transactionid){
    $pdo = Connect::getDb();
    $query=$pdo->query("SELECT transactions.*,userid,platformid,gameid from transactions,user_item where transactions.id=$transactionid and olditemid=user_item.id");
    $query->setFetchMode(\PDO::FETCH_CLASS,'App\Model\Transaction');
    return $query->fetch(); 
}
}