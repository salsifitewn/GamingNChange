<?php
use App\Connect;

\App\Helpers\Auth::forcer_utilisateur_connecte();
$user = (int) $_SESSION['id'];
$gameid = (int) $_GET['id'] ?? null;
$platformid = (int) $_GET['platform'] ?? null;

if (is_null($gameid) || is_null($platformid))
    header("location:accueil");

$pdo = Connect::getDB();
$query = $pdo->query("SELECT * FROM user_item where userid=$user and gameid=$gameid and platformid=$platformid and quantityToSell>0");
if ($query->fetch() != null)
    $msg="déjà possédé";
else {
    if (!($pdo->exec("INSERT IGNORE into user_item(userid,gameid,platformid,quantityToBuy,valueToBuy) values ($user,$gameid,$platformid,1,-1)
        on duplicate key update quantityToBuy=quantityToBuy+1")))
        $msg= "Ajout supplémentaire dans la liste de souhaits";
    else
        $msg= "Ajouté!";
}
header("location:Wishlist?msg=$msg");

?>
<div class="container mt-4 ">

<div class="alert alert-info alert-dismissible fade show">
    <?= htmlentities($msg) ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
</div>
