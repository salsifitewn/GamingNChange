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
<!-- <div class="container">
    
    <div class="row">
        <div class="col-xl-6">
            <div class="alert alert-primary" role="alert">
                A simple primary alert—check it out!
            </div>
        </div>
        <div class="col-sm border">
            <h1>COUCOU</h1>
        </div>
        <div class="col-sm">
            <h1 class="text-danger">COUCOU</h1>
        </div>

    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xl-6">
            <div class="alert alert-primary" role="alert">
                A simple primary alert—check it out!
            </div>
        </div>
        <div class="col-sm border">
            <h1>COUCOU</h1>
        </div>
        <div class="col-sm">
            <h1 class="text-danger">COUCOU</h1>
        </div>

    </div>
</div> -->
<?php
//  require_once dirname(__dir__) . '/class/Igdb.php';
/* $igdb = new Igdb("665a4a7b1bcc4222453547bbcd4455f2");
$games = $igdb->getLastGames();
 */
$pdo = App\Connect::getDB();
$query = $pdo->query("select distinct games.* from games,user_collection where user_collection.gameid=games.id ORDER BY RAND( ) LIMIT 12");
$games = $query->fetchAll(PDO::FETCH_CLASS,'App\Model\Game');
/* $publisherid=""; 
foreach ($games as $game){
    $publisherid .= (",".$game['involved_companies'][0])??null;
}
echo $publisherid; */
?>
<div class="container mt-2 ">
    <h2>Sélection de quelques titres disponibles</h2>
<div class="row">
                <?php foreach ($games as $game) :
                    require(dirname(__DIR__) . "/view/elements/cardGame.php");
                endforeach ?>
            </div>
    </div>
</div>
<?php //require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . 'layout.php'; 
