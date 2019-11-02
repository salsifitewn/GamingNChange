<?php
//utilisation des cookies
//App\Helpers\Auth::forcer_utilisateur_connecte();
$cart = [];
if (isset($_COOKIE['cart']))
    $cart = unserialize($_COOKIE['cart']);
$itemid = (int) $_GET['itemid'] ?? null;
$error = "";
if (is_null($itemid))
    $error = "erreur d'item";
if ($error === "") {
    if (isset($_SESSION['id'])&&App\Table\UserItemTable::getOwner($itemid) == (int) $_SESSION['id'])
        $error = "Vous êtes le propriétaire du jeu";
    else {
        if (App\Table\UserItemTable::getQuantityToSell($itemid)==0)
            $error = "La personne n'a plus le jeu";
        else {
            if (in_array($itemid, $cart))
                $error = "Article déjà dans votre panier";
            else {
                $cart[] = $itemid;
                setcookie('cart', serialize($cart));
                $error = "Article ajouté dans votre panier";
            }
        }
    }
}
$uri = $_SERVER['HTTP_REFERER'] . "&cart=" . $error;
header("location:$uri");
