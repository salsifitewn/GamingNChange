<?php
\App\Helpers\Auth::forcer_utilisateur_connecte();
$user = App\Model\User::getUser((int) $_SESSION['id']);
$games = $user->getGames();
?>
<div class="container">
    <div class="row mt-3">

        <h2 class="col">Mes jeux</h2>
<a class="btn btn-primary col-2" href="ajoutjeu">Ajout manuel d'un jeu</a>

    </div>
    <div class="row mt-3">
        <?php foreach ($games as $game) :
            require(dirname(__DIR__) . "/view/elements/cardGame.php");
        endforeach ?>

    </div>

</div>
