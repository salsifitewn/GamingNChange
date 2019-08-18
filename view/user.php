<?php
//LIste des jeux par utilisateur
$user = App\Model\User::getUser((int) $_GET['id']);
$games = $user->getGames();

?>
<div class="container">
    <div class="row mt-3">

        <h2 class="col">La Collection de Untel</h2>
<a class="btn btn-primary col-2" href="ajoutjeu">Ajout manuel d'un jeu</a>

    </div>
    <div class="row mt-3">
        <?php foreach ($games as $game) :
            require(dirname(__DIR__) . "/view/elements/cardGame.php");
        endforeach ?>

    </div>

</div>
