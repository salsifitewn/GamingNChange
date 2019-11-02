<?php
$backgroundcolor = "bg-warning";
App\Helpers\Auth::forcer_utilisateur_connecte();
$user = App\Table\UsersTable::getUser($_SESSION['id']);
$games = $user->getWishlistedGames();
$msg = htmlentities($_GET['msg'] ?? null);
?>
<?php if (!empty($msg)) : ?>
    <div class="container mt-2">
        <div class="alert alert-info alert-dismissible fade show">
            <?= $msg ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php endif ?>
<div class="container mt-2">
    <h1>Ma liste de souhaits </h1>
    <div class="row">
        <?php foreach ($games as $game) :
            require(dirname(__DIR__) . "/view/elements/cardGame.php");
        endforeach ?>
    </div>
</div>