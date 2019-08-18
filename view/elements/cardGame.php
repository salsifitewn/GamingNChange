<?php

use App\Helpers\Text;
use App\Model\User;

$newEntry = false;
$own = "";
$wishlisted = "";
if (App\Helpers\Auth::est_connecte()) {
    $user = User::getUser((int) $_SESSION['id']);
    $myGames = $user->getGames();
    $myGameIds = [];
    foreach ($myGames as $myGame)
        $myGameIds[] = $myGame->id;
    if (in_array($game->id, $myGameIds))
        $own = "own";
    $myWishGames = [];
    $myWishlistGames = $user->getWishlistedGames();
    foreach ($myWishlistGames as $myGame)
        $myWishGames[] = $myGame->id;
    if (in_array($game->id, $myWishGames))
        $wishlisted = "wishlisted";
}

$publishers = $game->getPublishers();
$developers = $game->getDevelopers();
$platforms = $game->getPlatforms();
if (!is_null($platforms))
    $newEntry = true;
$url = ROOT_IMG . $game->url ?? ''; ?>
<div class="col-lg-3 col-md-6">
    <div class="card <?= $wishlisted ?> <?= $own ?>mb-3">
        <a class="img-card" href="jeu?id=<?= $game->id ?>"><img src="<?= $url ?? '...' ?>" class="card-img-top thumbnail" alt="<?= $game->name ?>"></a>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <a href="jeu?id=<?= $game->id ?>">
                        <h6 class="card-title"><?= $game->name ?></h6>
                    </a></div>
            </div>
            <div class="row">
                <div class="col-8">
                    <h5>Score: <?= $game->score ?></h5>
                </div>
            </div>
            <?php if ($newEntry) : ?>
            <div class="row">
                    <div class="col-sm">
                        <span class="card-text font-weight-bold">Publishers: </span>
                        <ul class=" ">
                            <li class="badge badge-secondary"><?= $publishers[0] ?? '' ?></li>

                            <?php if (count($publishers) > 1) : ?>
                                <li>...</li>
                            <?php endif ?>
                        </ul>
                    </div>
                    <div class="col-sm">
                        <span class="card-text font-weight-bold">Developers: </span>
                        <ul class="small">
                            <li><?= $developers[0] ?? '' ?></li>
                            <?php if (count($developers) > 1) : ?>
                                <li>...</li>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($platforms as $platform) : ?>
                        <div class="col-3">
                            <span class="badge badge-light">
                            <img src="<?= ROOT_IMG . $platform['url_logo'] ?>" alt="<?= $platform['name'] ?>" class=" platform img-fluid">
                            </span>
                        </div>
                    <?php endforeach ?>
                </div>
                
            <?php endif ?>
            <!-- <p class="card-text">
            //Text::excerpt($game->summary ?? 'Pas de Résumé', 150) 
             
            </p> -->
        </div>
    </div>
</div>