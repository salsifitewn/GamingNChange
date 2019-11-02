<?php

namespace App\Table;

use App\Connect;
use App\Table\UsersTable;
class UserItemTable extends Table
{
    //id,userid,gameid,platformid,quantityToSell,quantityToBuy,valueToSell,valueToBuy
    public static function getOwner($itemid)
    {
        $pdo = Connect::getDb();
        return $pdo->query("SELECT userid from user_item where id=$itemid")->fetch()[0];
    }

    public static function getItem($itemid)
    {
        $pdo = Connect::getDb();
        $query = $pdo->query("SELECT * from user_item where id=$itemid");
        $query->setFetchMode(\PDO::FETCH_CLASS, 'App\Model\Item');
        return $query->fetch();
    }

    public static function isWishlisted($userid,$gameid,$platformid){
        $pdo = Connect::getDb();
        return !empty($pdo->query("SELECT * from user_item where userid=$userid and gameid=$gameid and platformid=$platformid and quantityToBuy>0")->fetch()[0]);
    }

    public static function getQuantityToSell($itemid)
    {
        $pdo = Connect::getDb();
        return $pdo->query("SELECT quantityToSell from user_item where id=$itemid")->fetch()[0];
    }

    public static function getGame($itemid)
    {
        $pdo = Connect::getDb();
        $query = $pdo->query("SELECT games.* from user_item,games where user_item.id=$itemid and user_item.gameid=games.id");
        $query->setFetchMode(\PDO::FETCH_CLASS, 'App\Model\Game');
        return $query->fetch();
    }
    public static function getItemid($ownerid, $gameid)
    {
        $pdo = Connect::getDb();
        return $pdo->query("SELECT id from user_item where gameid=$gameid and userid=$ownerid")->fetch()[0];
    }

    public static function getGameValue($itemid)
    {
        $pdo = Connect::getDb();
        return $pdo->query("SELECT valueToSell from user_item where id=$itemid")->fetch()[0];
    }

    public static function setGameValue($itemid, int $newvalue)
    {
        
        $pdo = Connect::getDb();
        $pdo->exec("UPDATE IGNORE user_item set valueToSell=$newvalue  where id=$itemid ");
    }

    public static function transaction($item, $newOwner)
    {
        $pdo = Connect::getDb();
        $pdo->beginTransaction();
        $oldOwner=UsersTable::getUser($item->userid);

        if ($oldOwner->remove($item->gameid, $item->platformid) != 0 && $newOwner->add($item->gameid, $item->platformid) != 0 && ($pdo->exec("INSERT Into transactions(buyerid,olditemid,price,status) values ({$newOwner->id},{$item->id},{$item->valueToSell},0)") != 0))
            $pdo->commit();
        else
            $pdo->rollBack()();
    }
}
