<?php
$allPlatforms=App\Table\PlatformTable::getAllPlatforms();
?>
<!DOCTYPE html>
<html class="h-100" lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $title ?? 'GameNchange.fr' ?></title>
  <link rel="stylesheet" href="assets\bootstrap-4.3.1-dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="css\stylesheet.css">


</head>

<body class="d-flex flex-column ">

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">

    <a class="navbar-brand" href="<?= $router->url('accueil')?>"><img class="img-fluid" width="30" height="30" src="assets\logo.svg" alt="GameNchange.fr"></a>
    <a class="navbar-brand" href="<?= $router->url('accueil')?>">GamingNChange.fr</a>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample03">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/">Accueil <span class="sr-only">(current)</span></a>
        </li>
        <?php if (\App\Helpers\Auth::est_connecte() && $_SESSION['role'] == 0) : ?>
          <li class="nav-item">
            <a class="nav-link" href="adminer.php">adminer</a>
          </li>
        <?php endif ?>
        <!--   <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
        </li> -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon Compte</a>
          <div class="dropdown-menu" aria-labelledby="dropdown03">
            <a class="dropdown-item" href="ajoutjeu">Ajout manuel d'un jeu</a>
            <a class="dropdown-item" href="utilisateur">Ma Page</a>
            <a class="dropdown-item" href="mon_inventaire">Mes Jeux</a>
            <a class="dropdown-item" href="transactions">Mes Transactions</a>
            <a class="dropdown-item" href="Wishlist">Mes Souhaits</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $router->url('help')?>">Aide</a>
        </li>
      </ul>

      <?php if (\App\Helpers\Auth::est_connecte()) : ?>
    <span class="navbar-text text-success">Connecté en tant que <?= htmlentities($_SESSION['username'] ?? "") ?></span>
    <?php endif ?>
      <form action="/recherche" method="GET" class="form-inline m-2 my-md-0">
      <select class="custom-select mr-2" name="console" id="">
            <option value="0" selected>Toutes Platformes</option>
            <?php foreach($allPlatforms as $platform): ?>
            <option value="<?= $platform['id']?>'"><?= $platform['name']?></option>
            <?php endforeach ?>
          </select>
        <input class="form-control" name="search" type="text" placeholder="Recherche Jeu">
      
      </form>

    </div>
    
    <!-- Button trigger modal -->
    <?php if (\App\Helpers\Auth::est_connecte()) : ?>
      <a href="logout" class="btn btn-danger">
        Se Deconnecter
      </a>
      <!-- <button class="nav-item"><a href="/logout" class="nav-link">Se déconnecter</a> -->
      <!-- </li> -->
    <?php else : ?>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Se Connecter
      </button>
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Se Connecter</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="login" method="post">
                <div class="form-group">
                  <label for="username">Votre identifiant</label>
                  <input type="text" name="username" id="" class="form-control" placeholder="Votre identifiant" required>
                  <div class="invalid-feedback"><?= $errors['login'] ?? '' ?></div>

                  <label for="password">Votre mot de passe</label>
                  <input type="password" name="password" id="" class="form-control" placeholder="Votre mot de passe" required>
                  <div class="invalid-feedback"><?= $errors['password'] ?? '' ?></div>

                </div>
                <div class="modal-footer">
                  <a href="/login" type="button" class="btn btn-success">Inscription</a>
                  <button type="submit" class="btn btn-primary">Valider</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endif ?>
    <a class="nav-link" href="panier"><img class="img-fluid" width="30" height="30" src="assets\cart.png" alt="Panier"></a>

  </nav>
  <main class="<?= $backgroundcolor??"" ?>">
    <?= $pageContent ?>
  </main>
  <footer class="bg-light py-4 footer mt-2">
    <div class="container">
      <?php if (defined('DEBUG_TIME')) : ?>
        Page générée en <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> ms
      <?php endif ?>
    </div>
  </footer>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</body>

</html>