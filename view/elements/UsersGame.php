<?php
$user = "";
$owned = "";
//$game
if (App\Helpers\Auth::est_connecte()) {
    $user = $_SESSION['id'];
}

?>
<div class="container">
    <div class="row">
        <h3>Liste des propriétaires du jeu par plateforme</h3>
    </div>
    <?php foreach ($platforms as $platform) : ?>
        <?php $owners = $game->getOwners($platform['id']); ?>
    <div class="row bg-dark">
        <h4 class="col text-light"><?= $platform['name'] ?>  </h4>
        <?php if($user!="") :?>
        <a class="col-2 btn-sm btn-success mr-2" href="ajoutjeu?platformSelected=<?=$platform['id'] ?>&gameSelected=<?= $game->id?> ">Je l'ai</a>
        <a class="col-2 btn-sm btn-secondary" href="ajouterJeuWishlist?platform=<?=$platform['id'] ?>&id=<?= $game->id?> ">Ajouter à ma liste de souhaits</a>
        <?php else :?>
        <a class="col-2 btn btn-secondary" href="login">Se Connecter pour consulter ma liste de souhaits</a>
        <?php endif ?>
        
    </div>  
        <?php if (!empty($owners)) : ?>
            <div class="row">

                <table class="table">
                    <tr>
                        <th>Nom du Propriétaire</th>
                        <th colspan="2">Prix Demandé</th>
                    </tr>
                    <?php foreach ($owners as $owner) : ?>
                        <?php if ($user == $owner->id)
                            $owned = "connecte";
                        ?>
                        <tr>
                            <td class="<?= $owned ?>"><a href="utilisateur/<?=$owner->id?>/collection"><?= $owner->username ?></a></td>
                            <?php if ($user == $owner->id) : ?>
                                <td>
                                    <form action="modifierjeu" method="get">
                                    <input type="number" name="platform" id="" value="<?= $platform['id'] ?>" hidden>
                                    <input type="number" name="game" id="" value="<?= $game->id ?>" hidden>
                                    <input type="number" name="value" id="" value="<?= $owner->value ?>">€
                                </td>
                                <td>
                                    <input type="submit" class="btn btn-danger" value="Modifier mon prix">
                                    </form>
                                <?php else : ?>
                                <td>
                                    <?= $owner->value ?>€
                                </td>
                                <td>
                                    <a class="text-righ btn btn-primary" href="ajoutPanier?gameid=<?=$game->id?>&platformid=<?=$platform['id']?>&vendorid=<?=$owner->id?>">Demande d'achat</a>
                                    

                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>

        <?php else : ?>
            <div class="row">
                <p>Personne ne possède le jeu</p>
            </div>
        <?php endif ?>
    <?php endforeach ?>
</div>