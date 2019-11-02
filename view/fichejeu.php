<?php

use App\Helpers\Text;

$gameid = (int) ($_GET['id'] ?? null);
$game = App\Table\GamesTable::getGame($gameid);
$platforms = $game->getPlatforms();
$title = $game->name ?? 'Jeu inconnu';
if (App\Helpers\Auth::est_connecte()) {
    $user = App\Table\UsersTable::getUser((int) $_SESSION['id']);
    if (isset($_GET['platformSelected']))
        $user->add((int) $_GET['id'], (int) $_GET['platformSelected']);
}
?>
<style>
    .screenshot {
        object-fit: cover;
        width: 100%;
        height: 90vh;
        background-image: url("img/<?= $game->url_screenshot ?>");
        background-repeat: no-repeat;
        background-size: cover;
        z-index: 1;
        position: relative;
    }

    .screenshot h1 {
        padding: 50px;
        text-align: center;
        z-index: 2;
        position: absolute;
        color: #FFF;
        font-size: 7em;
        bottom: 0;
        right: 0;
        -webkit-text-stroke-width: 2px;
        -webkit-text-stroke-color: black;
        font-weight: bold;
    }
</style>
<?php if (isset($_GET['cart'])) : ?>
    <div class="container mt-4 ">

        <div class="alert alert-info alert-dismissible fade show">
            <?= htmlentities($_GET['cart']) ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php endif ?>
<div class="container-fluid screenshot">
    <h1><?= $game->name ?></h1>
</div>
<div class="container mt-4">
    <div class="media">
        <img src="img/<?= $game->url ?>" class="Img thumbnail" alt="<?= $game->name ?>">
        <div class="table-responsive-sm media-body ml-3">
            <table class="table">
                <tr>
                    <th>Plateforme</th>
                    <td scope='col'>
                        <?php if (isset($platforms)) : ?>
                            <?php foreach ($platforms as $platform) : ?>
                                <span class="badge badge-secondary"><?= $platform['name'] ?></span>
                            <?php endforeach ?>
                        <?php endif ?>
                    </td>
                </tr>
                <tr>
                    <th>Année de 1ère sortie</th>
                    <td>
                        <?= $game->first_release_year ?>
                    </td>
                </tr>
                <tr>
                    <th>Score</th>
                    <td scope='col'>
                        <?= $game->score ?>
                    </td>
                </tr>
                <tr>
                    <th>Editeurs</th>
                    <td>
                        <?= $game->first_release_year ?>
                    </td>
                </tr>
                <tr>
                    <th>Développeurs</th>
                    <td>
                        <?= $game->first_release_year ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="container">
    <h3>Résumé</h3>
    <p><?= nl2br(htmlentities($game->summary, ENT_COMPAT, "cp1252")) ?? 'Pas de Résumé' ?></p>
</div>
<?php

//var_dump($collection)
?>


<?php require(dirname(__DIR__) . "/view/elements/UsersGame.php");
