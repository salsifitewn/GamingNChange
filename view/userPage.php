<?php
//LIste des jeux par utilisateur
if (isset($_GET['id'])) {
    $user = App\Table\UsersTable::getUser((int) $_GET['id']);
} else {
    App\Helpers\Auth::forcer_utilisateur_connecte();
    $user = App\Table\UsersTable::getUser((int) $_SESSION['id']);
}
$games = $user->getGamesToSell();

?>
<div class="container">
    <div class="row mt-3">

        <h2 class="col">Etalage de <?= $user->username ?></h2>

    </div>
    <div class="row mt-3">
        <?php if (empty($games)) : ?>
        <h2>Vous n'avez proposé aucun jeu à la vente</h2>
        <?php else : ?>
            <?php foreach ($games as $game) :
                    require(dirname(__DIR__) . "/view/elements/cardGame.php");
                endforeach ?>
        <?php endif ?>
    </div>

</div>