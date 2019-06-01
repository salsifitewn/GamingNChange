
<?php
use App\Connect;

$title='Se Connecter';
$errors['username']="trop fort";
$page_origin=$_SERVER['HTTP_REFERER']??null; ?>

<?php
$erreur = null;
if(!empty($_POST['username'])&& !empty($_POST['password'])){
        $pdo=Connect::db_connect();
        $sql="SELECT * FROM users where username=:username and password=:password";
        $query=$pdo->prepare($sql);
        $query->execute([
            ':username'=>$_POST['username'],
            ':password'=>$_POST['password']
        ]);
        $resultat=$query->fetchAll();
        var_dump($resultat);
        die();
    if($_POST['username']==='John' && $_POST['password']==='Doe'){
        session_start();
        $_SESSION['connecte']=1;
        header('Location: /admin');
    }else{
        $erreur="Identifiants incorrects";
    }
}
//  require_once 'functions/auth.php';

if(\App\Helpers\Auth::est_connecte()){
    header('Location: /admin');
}
?>
<?php if($erreur): ?>
<div class="alert alert-danger">
<?= $erreur ?>
</div>
<?php endif ?>
<?php if(!is_null($page_origin)): ?>
<div class="container">
    <div class="row">
        <div class="col-xl-6">
            <div class="alert alert-primary" role="alert">
                Merci de vous connecter
            </div>
        </div>  
</div>
<?php endif ?>
<div class="container">
    <form action="" method="post" class="form-signin">
        <div class="form-group">
            <input type="text" name="username" id="" class="form-control" placeholder="Login" required>
            <?php if (isset($errors['username'])): ?>
            <div class="invalid-feedback"><?= $errors['username'] ?></div>
            <?php endif ?>
        </div>
        <div class="form-group">
            <input type="password" name="password" id="" class="form-control" placeholder="Mot de passe" required>
            <?php if (isset($errors['password'])): ?>
            <div class="invalid-feedback"><?= $errors['password'] ?></div>
            <?php endif ?>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>


