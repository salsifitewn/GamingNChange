<?php
use App\Igdb;
use App\Helpers\Text;

$title = 'Accueil';
?>
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
 $igdb = new Igdb("665a4a7b1bcc4222453547bbcd4455f2");
$games = $igdb->getLastGames();
 


/* $publisherid=""; 
foreach ($games as $game){
    $publisherid .= (",".$game['involved_companies'][0])??null;
}
echo $publisherid; */
?>
<div class="container mt-4">
    <div class="row">
        <?php if (!is_null($games)) :?>
        <?php foreach ($games as $game) : ?>
            <?php $url = Igdb::getCover($game['cover']['url'] ?? ''); ?>

            <div class="col-lg-4 col-md-6">
                <div class="card mb-3">
                    <img src="<?= $url ?? '...' ?>" class="card-img-top thumbnail" alt="<?= $game['name'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $game['name'] ?></h5>
                        <!-- <p class="card-text"> ?=$igdb->getPublisher($game['id'])?></p> -->

                        <p class="card-text"><?= Text::excerpt($game['summary'] ?? 'Pas de Résumé', 100) ?></p>

                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        <?php endif ?>
    </div>
</div>
<?php //require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . 'layout.php'; 
