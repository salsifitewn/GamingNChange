<?php
//page recap? achat panier?
//App\Helpers\Auth::forcer_utilisateur_connecte();
$cart = [];
if(isset($_GET['emptyCart'])&&($_GET['emptyCart']==1)&&isset($_COOKIE['cart'])){
unset($_COOKIE['cart']); 
setcookie('cart'); 
}
if (isset($_COOKIE['cart']))
    $cart = unserialize($_COOKIE['cart']);
$games = [];
$pdo = App\Connect::getDB();
$total=0;
foreach ($cart as $article) {

    $query = $pdo->query("SELECT * from games where id={$article['gameid']}");
    $query->setFetchMode(\PDO::FETCH_CLASS, 'App\Model\Game');
    $game= $query->fetch();
    $vendor=App\Model\User::getUser($article['vendorid']);
    $total+=$vendor->getGameValue($article['gameid'],$game->platformid)??null;
    $games[] = $game;
    
}
?>
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
        <?php foreach ($games as $game) : ?>
        <?php require(dirname(__DIR__) . "/view/elements/cardGame.php"); ?>
            Price :
            <?php $cartTotal+= $game['value']?>
        <?php endforeach ?>
    </div>
    <div class="row d-flex justify-content-end ">
        <span><?=$total?></span>
        <a class="btn btn-primary mr-3" href="?emptyCart=1">Vider le panier</a>
        <a class="btn btn-primary " href="achat">Achat</a>
    </div>
</div>
<?php endif ?>