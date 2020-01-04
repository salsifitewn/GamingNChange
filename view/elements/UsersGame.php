<?php
$user = "";
$owned = "";
//$game
if (App\Helpers\Auth::est_connecte()) {
    $user = App\Table\UsersTable::getUser((int) $_SESSION['id']);
    $itemid = (int) ($_GET['itemid'] ?? null);
    $modifiedPrice = (int) ($_GET['price'] ?? null);
    if ($itemid != null && $modifiedPrice != 0) {
        if ($user->id == (App\Table\UserItemTable::getOwner($itemid))) {
            App\Table\UserItemTable::setGameValue($itemid, $modifiedPrice);
            $msg = "Prix modifié avec succès.";
            $status = "success";
        } else {
            $msg = "Vous ne pouvez pas changer le prix car vous n'êtes pas le propriétaire du jeu.";
            $status = "danger";
        }
    }
    $wisheditems = $user->getWishlistedItems();
    $wisheditemsids = [];
}
?>
<?php if (isset($msg)) : ?>
    <div class="container">
        <div class="alert alert-<?= $status ?> alert-dismissible fade show" id="focus">
            <?= $msg ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php endif ?>
<div class="container">
    <div class="row">
        <h3>Liste des propriétaires du jeu par plateforme</h3>
    </div>
    <?php foreach ($platforms as $platform) : ?>
        <?php $owners = $game->getOwners($platform['id']); ?>
        <div class="row bg-light">
            <img height="50" class="img" src="img/<?= App\Table\PlatformTable::getPlatformImg($platform['id']) ?>" alt="">
            <h4 class="col text-dark"><?= $platform['name'] ?> </h4>
            <?php if (isset($user->id) &&  $user->id != "") : ?>
                <a class="col-2 btn-sm btn-success mr-2" href="jeu?platformSelected=<?= $platform['id'] ?>&id=<?= $game->id ?>#focus">Je l'ai</a>
                <?php if (isset($user) && App\Table\UserItemTable::isWishlisted($user->id, $game->id, $platform['id'])) : ?>
                    <a class="col-2 btn-sm btn-warning" href="retirerJeuWishlist?platform=<?= $platform['id'] ?>&id=<?= $game->id ?> ">Retirer de la liste de souhaits</a>
                <?php else : ?>
                    <a class="col-2 btn-sm btn-secondary" href="ajouterJeuWishlist?platform=<?= $platform['id'] ?>&id=<?= $game->id ?> ">Ajouter à ma liste de souhaits</a>

                <?php endif ?>

            <?php else : ?>
                <a class="col-2 btn btn-secondary" href="login">Connectez-vous pour l'ajouter</a>
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
                        <?php $ownedmsg= (isset($user->id) && $user->id == $owner->id)? " (Vous)": ""  ?>
                        <tr>
                            <td class="<?= $owned ?>"><a href="utilisateur?id=<?= $owner->id ?>"><?= $owner->username ?><span class="badge badge-warning"><?= $ownedmsg ?? "" ?></span></a></td>
                            <?php if (isset($user->id) && $user->id == $owner->id) : ?>
                                <td>
                                    <form action="" method="get">
                                        <input type="number" name="itemid" id="" value="<?= App\Table\UserItemTable::getItemid($user->id, $game->id) ?>" hidden>
                                        <input type="number" name="id" id="" value="<?= $game->id ?>" hidden>
                                        <input type="number" name="price" id="" value="<?= $owner->valueToSell ?>">€ (mettre à 0 ou moins si vous ne voulez pas le mettre en vente)
                                        <input type="submit" class="btn btn-danger" value="Modifier mon prix">
                                    </form>
                                </td>

                            <?php else : ?>
                                <td>
                                    <?php if ($owner->valueToSell <= 0) : ?>
                                        Pas disponible à la vente
                                    <?php else : ?>
                                        <?= $owner->valueToSell ?>€

                                </td>
                                <td>
                                    <a class="text-righ btn btn-primary" href="ajoutPanier?itemid=<?= $owner->itemid ?>">Demande d'achat</a>


                                </td>
                            <?php endif ?>
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