<!DOCTYPE html>
<html class="h-100" lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $title ?? 'GameNchange.fr' ?></title>
  <link rel="stylesheet" href="assets\bootstrap-4.3.1-dist\css\bootstrap.min.css">

</head>

<body class="d-flex flex-column h-100">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">

    <a class="navbar-brand" href=""><img class="img-fluid" width="36" height="36" src="assets\logo.svg" alt="GameNchange.fr"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample03">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="">Accueil <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu" aria-labelledby="dropdown03">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact">Contact</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-md-0">
        <input class="form-control" type="text" placeholder="Search">
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <input type="text" name="username" id="" class="form-control" placeholder="Votre identifiant">
                <div class="invalid-feedback"><?= $errors['login'] ?? '' ?></div>

                <label for="password">Votre mot de passe</label>
                <input type="password" name="password" id="" class="form-control" placeholder="Votre mot de passe">
                <div class="invalid-feedback"><?= $errors['password'] ?? '' ?></div>

              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Valider</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  <?php endif ?>
  </nav>
  <?= $pageContent ?>
  <footer class="bg-light py-4 footer ">
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