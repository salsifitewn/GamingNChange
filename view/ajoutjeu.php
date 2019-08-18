<?php
use App\Table\GamesTable;

\App\Helpers\Auth::forcer_utilisateur_connecte();
$user=App\Model\User::getUser((int)$_SESSION['id']);
$title = 'Recherche Jeu';
$igdb = new App\Igdb("665a4a7b1bcc4222453547bbcd4455f2");
$game = null;
if (isset($_GET['gameSelected'])&&isset($_GET['platformSelected'])) {
    //$game = App\Igdb($_GET['gameSelected']);
    $id = (int)$_GET['gameSelected'];
    $res = \App\Connect::getDB()->query("select * from games where id=$id")->fetch(pdo::FETCH_ASSOC);
    if (!$res) {
        $gameid = $id;
        $game = $igdb->getGame($gameid);
        GamesTable::addGames($game);        
        echo "Nouveau jeu ajouté<br>";

    }
    $user->add($_GET['gameSelected'],$_GET['platformSelected']);
    echo "Vous possédez maintenant ce jeu<br>";

}
$games = null;
if (isset($_GET['gameName']))
    $games = $igdb->searchGames($_GET['gameName']);
?>
<div class="container-fluid mt-4 ">
    <?php if (!is_null($games)) : ?>
        <div class="table-responsive-sm">
            <table class="table table-striped table-hover table-sm">
                <tr>
                    <th>Jaquette</th>
                    <th>Nom</th>
                    <th>Plateforme</th>
                    <th>Année</th>
                    <th>Resumé</th>
                </tr>
                <?php if (!is_null($games)) : ?>
                    <?php foreach ($games as $game) : ?>
                        <?php $url = App\Igdb::getCover($game['cover']['url'] ?? ''); ?>

                        <tr>

                            <td scope='col'><a href="?gameSelected=<?= $game['id'] ?>"><img src="<?= $url ?? '...' ?>" class="img thumbnail" alt="<?= $game['name'] ?>"></a></td>
                            <td scope='col'>
                                <a data-toggle="modal" data-target="#exampleModal" >
                                    <h5 class="card-title"><?= $game['name'] ?></h5>
                                </a>
                            </td>
                            <!-- <p class="card-text"> ?=$igdb->getPublisher($game['id'])?></p> -->
                            <td scope='col'>
                                <?php if (isset($game['platforms'])) : ?>
                                    <ul class="list-group small">
                                        <?php foreach ($game['platforms'] as $platform) : ?>
                                            <li class='list-group-item small'>
                                            <a href="?gameSelected=<?= $game['id'] ?>&platformSelected=<?=$platform['id']?>">
                                                <?= $platform['name'] ?>
                                                </a>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                <?php endif ?>
                            <td>
                                <?= date('Y', $game['first_release_date']) ?>

                            </td>
                            </td>
                            <td scope='col'>
                                <p class="small "><?= $game['summary'] ?? 'Pas de Résumé' ?></p>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </table>
        </div>
    </div>
<?php elseif (!is_null($game)) : ?>
    <p>Insertion réussi</p>
    
<?php else : ?>
    <div class="container">
        <form action="" method="GET">
            <div class="form-group">
                <label for="exampleInputEmail1">Nom du jeu</label>
                <input type="text" class="form-control" name="gameName">
            </div>
            <input type="submit" class="btn btn-primary" value="Chercher">
        </form>
    </div>
<?php endif ?>
</div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Choix de la plateforme</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                <input type="text" name="gameSelected" id="gameid" class="form-control"  required disabled>

                <label for="platform">Quelle Plateforme?</label>
                <select type="select" name="platform" id="platform">
                </select>
              </div>
              <a href="/login" type="button" class="btn btn-success">Valider</a>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
<script>
    function selectPlatform(){
        var sel = document.getElementById('platform');
    }
</script>