<?php
$title = 'Accueil';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "class/connection.php";
$pdo = db_connectDev();

$sql = 'SELECT * FROM Games';
$res = $pdo->query($sql);
$posts = $res->fetchAll();
?>
<table class="table">
    <?php foreach ($posts as $post) : ?>
        <tr>
            <td>
                <a href="/"> <?= $post['id']?></a>
            </td>
            <td>
                <?= $post['name'] ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>