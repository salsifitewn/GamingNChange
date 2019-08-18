<?php
use App\Helpers\Text;

$pdo = App\Connect::getDB();
$query = $pdo->query("select * from games where id={$_GET['id']}");
$query->setFetchMode(PDO::FETCH_CLASS, 'App\Model\Game');
$game = $query->fetch();
$platforms=$game->getPlatforms();
$title = $game->name ?? 'Jeu inconnu';
//var_dump($game);


?>
<div class="container mt-4 ">
    <?php if (isset($_GET['cart'])) : ?>
        <div class="alert alert-info alert-dismissible fade show">
            <?=htmlentities($_GET['cart'])?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
        </div>
    <?php endif ?>
</div>
<div class="container">
    <img src="img/<?= $game->url_screenshot ?>" class="img-fluid w-100" alt="<?= $game->name ?>">
</div>
<div class="container">
    <div class="table-responsive-sm">
        <table class="table">
            <tr>
                <th>Jaquette</th>
                <th>Nom</th>
                <th>Plateforme</th>
                <th>Année de 1ère sortie</th>
                <th>Resumé</th>
            </tr>
            <tr>

                <td scope='col'><img src="img/<?= $game->url?>" class="Img thumbnail" alt="<?= $game->name ?>"></td>
                <td scope='col'>
                    <h5 class="card-title"><?= $game->name ?></h5>
                </td>
                <!-- <p class="card-text"> ?=$igdb->getPublisher($game['id'])?></p> -->
                <td scope='col'>
                    <?php if (isset($platforms)) : ?>
                        <?php foreach ($platforms as $platform) : ?>
                            <span class="badge badge-secondary"><?= $platform['name'] ?></span>
                        <?php endforeach ?>
                    <?php endif ?>
                <td>
                    <?= $game->first_release_year ?>

                </td>
                </td>
                <td scope='col'>
                    <p class="card-text"><?= $game->summary ?? 'Pas de Résumé' ?></p>
                </td>
        </table>
    </div>
    <?php

    //var_dump($collection)
    ?>
    

    <?php require(dirname(__DIR__) . "/view/elements/UsersGame.php");