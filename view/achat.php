<?php
use App\Table\Userstable;
use App\Model\User;
App\Helpers\Auth::forcer_utilisateur_connecte()
$user=getUser((int)$_SESSION['id']);
//validation du panier et execution transaction
//check cookie panier
$articles=$_COOKIE['panier']??null;
if($articles!=null){
//check dispo
foreach($articles as $article){
$vendor=getUser((int)$article['vendorid']);
$games=$vendor->getGames();
}
//begin transaction
//commit
//suppr cookie
//message de confirmation
}