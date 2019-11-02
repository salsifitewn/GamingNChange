<?php

use App\Connect;

\App\Helpers\Auth::forcer_utilisateur_connecte();
$user = (int) $_SESSION['id'];
$gameid = (int) $_GET['id'] ?? null;
$platformid = (int) $_GET['platform'] ?? null;

if (is_null($gameid) || is_null($platformid))
    header("location:accueil");

$pdo = Connect::getDB();
$query = $pdo->query("SELECT * FROM user_item where userid=$user and gameid=$gameid and platformid=$platformid and quantityToBuy>0");
if (empty($query->fetch()))
    $msg = "Pas dans la liste de souhaits";
else {
    ($pdo->exec("UPDATE user_item SET quantityToBuy=0 where userid=$user and gameid=$gameid and platformid=$platformid"));
    $msg = "Retiré";
}

header("location:Wishlist?msg=$msg");
