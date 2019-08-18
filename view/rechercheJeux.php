<?php
use App\Connect;

$name = htmlentities($_GET['search'] ?? null);

if (!empty($name)) {
    $pdo = Connect::getDB();
    $query = $pdo->query("select * from games where LOWER(name) LIKE '%$name%'");
$games = $query->fetchAll(PDO::FETCH_CLASS, 'App\Model\Game');

}
?>
<?php if (!empty($name)) : ?>
    <div class="container mt-4">
        <?php if (!is_null($games)) : ?>
            <div class="row">
                <?php foreach ($games as $game) :
                    require(dirname(__DIR__) . "/view/elements/cardGame.php");
                endforeach ?>
            </div>
        <?php else : ?>
            <div class="alert alert-danger">Pas de jeu </div>
        <?php endif ?>
    </div>
<?php endif ?>