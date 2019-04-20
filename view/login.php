<?php ob_start()?>

<?php $errors['username']="trop fort"; ?>
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
<?php $pageContent= ob_get_clean();