<?php

use App\Helpers\Text;

$title = 'Accueil';
$backgroundimg="img/background.jpg";
$logout=$_GET['logout']??0;
?>
<div class="container mt-4 ">
    <?php if ($logout==1) : ?>
        <div class="alert alert-info alert-dismissible fade show">
            Vous avez bien été déconnecté
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
        </div>
    <?php endif ?>
</div>

<?php
//  require_once dirname(__dir__) . '/class/Igdb.php';
/* $igdb = new Igdb("665a4a7b1bcc4222453547bbcd4455f2");
$games = $igdb->getLastGames();
 */
$pdo = App\Connect::getDB();
$query = $pdo->query("select distinct games.* from games,user_item where quantityToSell>0 and valueToSell>0 and user_item.gameid=games.id ORDER BY RAND( ) LIMIT 8");
$availablesgames = $query->fetchAll(PDO::FETCH_CLASS,'App\Model\Game');
/* $publisherid=""; 
foreach ($games as $game){
    $publisherid .= (",".$game['involved_companies'][0])??null;
}
echo $publisherid; */
$pdo = App\Connect::getDB();
$query = $pdo->query("select distinct games.* from games,user_item where user_item.gameid=games.id and quantityToBuy>0  ORDER BY RAND( ) LIMIT 8");
$wantedgames = $query->fetchAll(PDO::FETCH_CLASS,'App\Model\Game');
$pdo = App\Connect::getDB();
$query = $pdo->query("select distinct games.* from games ORDER BY RAND( ) LIMIT 8");
$games = $query->fetchAll(PDO::FETCH_CLASS,'App\Model\Game');
?>
<div class="container mt-2 ">
    <h2>Sélection de quelques titres disponibles</h2>
<div class="row">
                <?php foreach ($availablesgames as $game) :
                    require(dirname(__DIR__) . "/view/elements/cardGame.php");
                endforeach ?>
            </div>
    </div>
</div>
<div class="container mt-2 ">
    <h2>Sélection de quelques titres recherchés</h2>
<div class="row">
                <?php foreach ($wantedgames as $game) :
                    require(dirname(__DIR__) . "/view/elements/cardGame.php");
                endforeach ?>
            </div>
    </div>
</div>
<div class="container mt-2 ">
    <h2>Avez-vous ces Jeux?</h2>
<div class="row">
                <?php foreach ($games as $game) :
                    require(dirname(__DIR__) . "/view/elements/cardGame.php");
                endforeach ?>
            </div>
    </div>
</div>
