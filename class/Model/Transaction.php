<?php

namespace App\Model;

use App\Connect;

class Transaction
{

    //utilisation de pdo fetchclass
    //id,buyerid,vendorid,platformid,date,status,price,date

    public function statusChange()
    {
        $pdo = Connect::getDB();
        return $pdo->exec("UPDATE transactions SET status=status+1 WHERE id={$this->id}");
    }
}
