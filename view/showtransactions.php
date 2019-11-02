<?php
\App\Helpers\Auth::forcer_utilisateur_connecte();
$user = App\Table\UsersTable::getUser((int) $_SESSION['id']);
$ventes = App\Table\TransactionsTable::getSales($user->id);
$achats = App\Table\TransactionsTable::getPurchases($user->id);

$venteids = [];
$achatids = [];
foreach ($ventes as $vente) {
    $venteids[] = (int) $vente->id;
}
foreach ($achats as $achat) {
    $achatids[] = $achat->id;
}
$achats = App\Table\TransactionsTable::getPurchases($user->id);
$statusMsgSeller = ['Demande d\'envoi', 'Attente de réception', 'Jeu reçu'];
$statusMsgBuyer = ['Envoi en cours', 'Jeu envoyé', 'Jeu reçu'];
$transactionid = (int) ($_GET['id'] ?? null);
if (in_array($transactionid, $venteids)) {
    $transaction = App\Table\TransactionsTable::getTransaction($transactionid);
    if ($transaction->userid == $user->id && $transaction->status == 0)
        $transaction->statusChange();
    $ventes = App\Table\TransactionsTable::getSales($user->id);
}
if (in_array($transactionid, $achatids)) {
    $transaction = App\Table\TransactionsTable::getTransaction($transactionid);
    if ($transaction->buyerid == $user->id && $transaction->status == 1)
        $transaction->statusChange();
    $achats = App\Table\TransactionsTable::getPurchases($user->id);
}
?>

<div class="container mt-4 ">
    <div class="table-responsive-sm">
        <table class="table table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th colspan="6">Mes Ventes</th>
                </tr>
            </thead>
            <tr>
                <th class="col-1">Date</th>
                <th class="col-2">Jeu</th>
                <th class="col-1">Platforme</th>
                <th class="col-1">Acheteur</th>
                <th class="col-1">Prix</th>
                <th class="col-1">Action</th>
            </tr>
            <?php if (empty($ventes)) : ?>
                <tr>
                    <td>Pas de Vente</td>
                </tr>
            <?php else : ?>
                <?php foreach ($ventes as $vente) : ?>
                    <tr>
                        <td class="col-1"><?= date("d/m/Y à G:H", strtotime($vente->date)) ?></td>
                        <td class="col-2"><a href="jeu?id=<?= App\Table\GamesTable::getGame($vente->gameid)->id ?>"><?= App\Table\GamesTable::getGame($vente->gameid)->name ?></a></td>
                        <td class="col-1"><?= App\Table\PlatformTable::getPlatformName($vente->platformid) ?></td>
                        <td class="col-1"><?= App\Table\UsersTable::getUser($vente->buyerid)->username ?></td>
                        <td class="col-1"><?= $vente->price . "€" ?></td>
                        <?php if ($vente->status == 0) : ?>
                            <td class="col-1"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Valider<?= $vente->id ?>">
                                    Valider l'envoi
                                </button></td>
                            <div class="modal fade" id="Valider<?= $vente->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Demande de confirmation</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Confirmer l'envoi de <?= App\Table\GamesTable::getGame($vente->gameid)->name ?>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <a href="\transactions?id=<?= $vente->id ?>" class="btn btn-primary">Valider</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif (($vente->status == 1)) : ?>
                            <td><button type="button" class="btn btn-success" disabled>
                                    Envoi confirmé
                                </button></td>
                        <?php else : ?>
                            <td><button type="button" class="btn btn-success" disabled>
                                    Transaction Terminée
                                </button></td>
                        <?php endif ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </table>
    </div>
    <div class="table-responsive-sm">
        <table class="table table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th colspan="6">Mes Achats</th>
                </tr>
            </thead>
            <tr>
                <th class="col-1">Date</th>
                <th class="col-2">Jeu</th>
                <th class="col-1">Platforme</th>
                <th class="col-1">Vendeur</th>
                <th class="col-1">Prix</th>
                <th class="col-1">Action</th>
            </tr>
            <?php if (empty($achats)) : ?>
                <tr>
                    <td>Pas d'achat</td>
                </tr>
            <?php else : ?>
                <?php foreach ($achats as $achat) : ?>
                    <tr>
                        <td class="col-1"><?= date("d/m/Y à G:H", strtotime($achat->date)) ?></td>
                        <td class="col-2"><a href="jeu?id=<?= App\Table\GamesTable::getGame($achat->gameid)->id ?>"><?= App\Table\GamesTable::getGame($achat->gameid)->name ?></a></td>
                        <td class="col-1"><?= App\Table\PlatformTable::getPlatformName($achat->platformid) ?></td>
                        <td class="col-1"><?= App\Table\UsersTable::getUser($achat->userid)->username ?></td>
                        <td class="col-1"><?= $achat->price . "€"  ?></td>
                        <?php if ($achat->status == 1) : ?>

                            <td class="col-1"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Valider<?= $achat->id ?>">
                                    Valider la reception
                                </button></td>
                            <div class="modal fade" id="Valider<?= $achat->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Demande de confirmation</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Confirmer la réception de <?= App\Table\GamesTable::getGame($achat->gameid)->name ?>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <a href="\transactions?id=<?= $achat->id ?>" class="btn btn-primary">Valider</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif ($achat->status == 0) : ?>
                            <td><button type="button" class="btn btn-warning" disabled>
                                    En attente de confirmation d'envoi
                                </button></td>
                        <?php else : ?>
                            <td><button type="button" class="btn btn-success" disabled>
                                    Transaction terminée
                                </button></td>
                        <?php endif ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </table>
    </div>