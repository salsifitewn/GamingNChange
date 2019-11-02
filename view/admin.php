<?php
use App\Helpers\Auth;
Auth::forcer_utilisateur_connecte();
$title='Admin';
if(!Auth::est_admin()){
    http_response_code(403);
    die('Forbidden');
}
?>
<div class="container">
    
</div>