<?php
//page recap? achat panier?
//App\Helpers\Auth::forcer_utilisateur_connecte();
$backgroundcolor="bg-info";
$cart = [];
if(isset($_GET['emptyCart'])&&($_GET['emptyCart']==1)&&isset($_COOKIE['cart'])){
unset($_COOKIE['cart']); 
setcookie('cart'); 
}
if (isset($_COOKIE['cart']))
    $cart = unserialize($_COOKIE['cart']);
$games = [];
$total=0;
foreach ($cart as $article) {

    $game=App\Table\UserItemTable::getGame($article);
    //$vendor=App\Model\User::getUser($article['vendorid']);
    //$total+=$vendor->getGameValue($article['gameid'],$game->platformid)??null;
    $games[] = [
        'game'=>$game,
        'price'=>App\Table\UserItemTable::getGameValue($article),
        'platformid'=>App\Table\UserItemTable::getItem($article)->platformid
    ];
}
 if(isset($_GET['error']))
$error=htmlentities($_GET['error'])
 

?>
<div class="container mt-4 ">
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif ?>
</div>
<div class="container mb-5">
    <div class="row">
        <h2>Votre Panier</h2>
    </div>
    <?php if (empty($games)) : ?>
        <div class="row d-flex justify-content-center ">
            Votre panier est vide
        </div>
    <?php else: ?>
    <div class="row">
        <?php foreach ($games as $item) : ?>
        <?php $game=$item['game'] ?>
        <?php require(dirname(__DIR__) . "/view/elements/cardGame.php"); ?>
            Prix :
            <?= $item['price']?>
        <?php $total+=(int)$item['price'] ?>

        <?php endforeach ?>
    </div>
    <div class="row d-flex justify-content-end ">
        <span class="btn"><?=$total?></span>
        <a class="btn btn-primary mr-3" href="?emptyCart=1">Vider le panier</a>
        <a class="btn btn-primary " href="achat">Achat</a>
    </div>
    <?php endif ?>
</div>
   