<?php

use App\Table\UsersTable;

App\Helpers\Auth::forcer_utilisateur_connecte();

$user = UsersTable::getUser((int) $_SESSION['id']);
if (isset($_COOKIE['cart']))
    $cart = unserialize($_COOKIE['cart']);
if(empty($cart)){
    header('Location: /panier');//normalement le chemin devrait être cart qui renverrai la vue panier
}
$items = [];
$error=0;
$total = 0;
//check cookie panier
//validation du panier
//recuperation de chaque vendeur

foreach ($cart as $itemid) {

    $item=App\Table\UserItemTable::getItem($itemid);
    if($item->quantityToSell<=0)
    $error=1;
    $transactions[]=[
        'item'=>$item,
        'user'=>$user
    ];
}
if($error==1)
    header('Location: /panier?error="notEnoughQty"');
// execution transaction
foreach ($transactions as $transaction) {
    App\Table\UserItemTable::transaction($transaction['item'],$user);    
}
//suppr cookie panier
if (isset($_COOKIE['cart'])) {
    unset($_COOKIE['cart']); 
    setcookie('cart', null, -1, '/'); 
}    
header('Location: /panier?success="1"');

//message de confirmation
