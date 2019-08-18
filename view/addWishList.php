<?php

use App\Connect;

\App\Helpers\Auth::forcer_utilisateur_connecte();
$user = (int) $_SESSION['id'];
$gameid = (int) $_GET['id'] ?? null;
$platformid = (int) $_GET['platform'] ?? null;

if (is_null($gameid) || is_null($platformid))
    header("location:accueil");

$pdo = Connect::getDB();
$query = $pdo->query("SELECT * FROM user_collection where userid=$user and gameid=$gameid and platformid=$platformid and quantityToSell>0");
if ($query->fetch() != null)
    echo "déjà possédé";
else {
    $rank=(int)($pdo->query("select max(rank) from user_wishlist where userid=$user")->fetch()??"0");
    if (!($pdo->exec("INSERT IGNORE into user_wishlist(userid,gameid,platformid,rank) values($user,$gameid,$platformid,$rank+1)")))
        echo "déjà dans la liste de souhaits";
    else
        echo "Ajouté!";
}

header("location:Wishlist");
