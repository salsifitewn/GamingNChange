<?php
use App\Connect;
use App\Model\User;

$title = 'Se Connecter';
$errors['username'] = "trop fort";
$errors = null;
if (strpos($_SERVER['HTTP_HOST'], 'login')) {
    $page_origin = $_SERVER['HTTP_REFERER'] ?? '/';
    if ($page_origin != '/')
        $page_origin = str_replace('http://' . $_SERVER['HTTP_HOST'], '', $page_origin);
} else {
    $page_origin = '/';
}


?>
<?php
$erreur = null;
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $pdo = Connect::getDB();
    $sql = "SELECT * FROM users where username=:username and password=:password";
    $query = $pdo->prepare($sql);
    $query->execute([
        ':username' => $username,
        ':password' => $password
    ]);
    $resultat = $query->fetch(PDO::FETCH_ASSOC);
    if (!empty($resultat)) {
        session_start();
        $_SESSION['connecte'] = 1;
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['username'] = $resultat['username'];
        $_SESSION['role'] = $resultat['role'];

        header("Location: $page_origin");
    } else {
        $erreur = "Identifiants incorrects";
    }
}
//  require_once 'functions/auth.php';

//creation new user
if (!empty($_POST['newusername']) && !empty($_POST['newpassword']) && !empty($_POST['newpasswordbis']) && !empty($_POST['email'])) {
    $username = htmlentities($_POST['newusername']);
    $password = htmlentities($_POST['newpassword']);
    $email = htmlentities($_POST['email']);
    if ($_POST['newpassword'] === $_POST['newpasswordbis']) {
        $res = User::insertNewUser($username, $password, $email);
        if ($res == 0)
            $errors = "L'inscription n'a pas pu aboutir";
        else {
            $errors = "Inscription Réussie";
        }
    }
}
if (\App\Helpers\Auth::est_connecte()) {
    header("Location: $page_origin");
}
?>
<div class="container mt-4 ">
    <?php if ($erreur) : ?>
        <div class="alert alert-danger">
            <?= $erreur ?>
        </div>
    <?php endif ?>
    <?php if (!is_null($page_origin)) : ?>
        <div class="alert alert-primary" role="alert">
            Merci de vous connecter ou de vous inscrire
        </div>
    <?php endif ?>
    <div class="alert alert-primary" role="alert">
        <?= $errors ?>
    </div>
</div>

<div class="container ">
    <div class="row ">
        <div class="col-md mt-2 bg-info rounded mr-1">
            <h5>Se connecter</h5>
            <form action="" method="post" class="form-signin">
                <div class="form-group">
                    <input type="text" name="username" id="" class="form-control" placeholder="Login" required>
                    <?php if (isset($errors['username'])) : ?>
                        <div class="invalid-feedback"><?= $errors['username'] ?></div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="" class="form-control" placeholder="Mot de passe" required>
                    <?php if (isset($errors['password'])) : ?>
                        <div class="invalid-feedback"><?= $errors['password'] ?></div>
                    <?php endif ?>
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
        </div>
        <div class="col-md mt-2 bg-success rounded ml-1">
            <div class="row">
            <h5>Nouvelle Inscription</h5>
            </div>
            <form action="" method="post" class="form-signin">
                <div class="form-group">
                    <input type="text" name="newusername" id="" class="form-control" placeholder="Login" required>
                    <?php if (isset($errors['username'])) : ?>
                        <div class="invalid-feedback"><?= $errors['username'] ?></div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="" class="form-control" placeholder="Email" required>
                    <?php if (isset($errors['email'])) : ?>
                        <div class="invalid-feedback"><?= $errors['username'] ?></div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <input type="password" name="newpassword" id="" class="form-control" placeholder="Mot de passe" required>
                    <?php if (isset($errors['password'])) : ?>
                        <div class="invalid-feedback"><?= $errors['password'] ?></div>
                    <?php endif ?>
                    <input type="password" name="newpasswordbis" id="" class="form-control mt-1" placeholder="Mot de passe" required>
                    <?php if (isset($errors['password'])) : ?>
                        <div class="invalid-feedback"><?= $errors['password'] ?></div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                </div>
            </form>
        </div>
    </div>
</div>