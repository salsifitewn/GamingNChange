<?php
ob_start();
use App\Igdb;

$title = 'Accueil';
?>
<div class="container">
    <div class="row">
        <div class="col-xl-6">
            <div class="alert alert-primary" role="alert">
                A simple primary alert—check it out!
            </div>
        </div>
        <div class="col-sm border">
            <h1>COUCOU</h1>
        </div>
        <div class="col-sm">
            <h1 class="text-danger">COUCOU</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="alert alert-primary" role="alert">
                A simple primary alert—check it out!
            </div>
        </div>
        <div class="col-sm border">
            <h1>COUCOU</h1>
        </div>
        <div class="col-sm">
            <h1 class="text-danger">COUCOU</h1>
        </div>

    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xl-6">
            <div class="alert alert-primary" role="alert">
                A simple primary alert—check it out!
            </div>
        </div>
        <div class="col-sm border">
            <h1>COUCOU</h1>
        </div>
        <div class="col-sm">
            <h1 class="text-danger">COUCOU</h1>
        </div>

    </div>
</div>

<?php
//  require_once dirname(__dir__) . '/class/Igdb.php';
$igdb = new Igdb("665a4a7b1bcc4222453547bbcd4455f2");
$igdb->getLastGames();
$pageContent = ob_get_clean();
?>