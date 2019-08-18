<?php
App\Helpers\Auth::forcer_utilisateur_connecte();
$user=App\Model\User::getUser($_SESSION['id']);
$games=$user->getWishlistedGames();
?>
<div class="container mt-2">
<h1>Ma liste de souhaits </h1>
<div class="row">
                <?php foreach ($games as $game) :
                    require(dirname(__DIR__) . "/view/elements/cardGame.php");
                endforeach ?>
            </div>
</div>
