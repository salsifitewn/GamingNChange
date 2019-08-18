<?php
//utilisation des cookies
//App\Helpers\Auth::forcer_utilisateur_connecte();
$cart = [];
if (isset($_COOKIE['cart']))
    $cart = unserialize($_COOKIE['cart']);
$game = (int) $_GET['gameid'] ?? null;
$platform = (int) $_GET['platformid'] ?? null;
$vendorid = (int) $_GET['vendorid'] ?? null;
$error = "";
if (is_null($game) || is_null($platform) || is_null($vendorid))
    $error = "erreur d'item";
if ($error === "") {
    if (isset($_SESSION['id'])&&$vendorid == (int) $_SESSION['id'])
        $error = "Vous êtes le propriétaire du jeu";
    else {
        $pdo = App\Connect::getDB();
        $query = $pdo->query("SELECT * from user_collection where userid=$vendorid and gameid=$game and platformid=$platform and quantityToSell>0");
        if (!$query->fetch())
            $error = "La personne n'a pas le jeu";
        else {
            $article = [
                'gameid' => $game,
                'platform' => $platform,
                'vendorid' => $vendorid
            ];
            if (in_array($article, $cart))
                $error = "Aricle déjà dans votre panier";
            else {
                $cart[] = $article;
                setcookie('cart', serialize($cart));
                $error = "Article ajouté dans votre panier";
            }
        }
    }
}
$uri = $_SERVER['HTTP_REFERER'] . "&cart=" . $error;
header("location:$uri");
