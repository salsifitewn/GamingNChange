<?php

use App\Connect;

$platform = "";
if (isset($_GET['console']) && (int) $_GET['console'] != 0) {
    $platform = "and game_platforms.id_platform=" . (int) $_GET['console'];
    $name = htmlentities($_GET['search'] ?? null);
}
$name=htmlentities($_GET['search']??null);
if (!empty($name)) {
    $pdo = Connect::getDB();
    $query = $pdo->query("select  games.* from games,game_platforms  where game_platforms.id_game=games.id and LOWER(name) LIKE '%$name%'" . $platform);
    $games = $query->fetchAll(PDO::FETCH_CLASS, 'App\Model\Game');
}
?>
<?php if (!empty($name)) : ?>
    <div class="container mt-4">
        <?php if (!empty($games)) : ?>
            <div class="row">
                <?php foreach ($games as $game) :
                            require(dirname(__DIR__) . "/view/elements/cardGame.php");
                        endforeach ?>
            </div>
        <?php else : ?>
            <div class="alert alert-danger">Pas de jeu trouvé. Réessayer avec une autre proposition ou connectez-vous pour rajouter un nouveau jeu</div>
        <?php endif ?>
    </div>
<?php endif ?>