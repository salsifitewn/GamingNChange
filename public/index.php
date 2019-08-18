<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use App\Router;
use App\Connect;
define("ROOT_IMG",'/img/');
define ('DEBUG_TIME',microtime(true));
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router = new Router(dirname(__DIR__).'/view');
$router->get('/jeu','fichejeu');
$router->get('/login','login');
$router->get('/logout','logout');
$router->get('/ajoutjeu','ajoutjeu');
$router->get('/recherche','rechercheJeux');
$router->get('/mon_inventaire','inventaire');
$router->get('/ajouterJeuWishlist','addWishList');
$router->get("/Wishlist",'wishList');
$router->get('/','accueil');
$router->get('/admin','admin');
$router->get('/ajoutPanier','addToCart');
$router->get('/panier','cart');



$router->run();
//dd($router->url( 'accueil', array( 'id' => 5 ) ));




/* require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'accueil.php';
*/


/*  $router->map( 'GET', '/', function() {
require dirname(__DIR__) .DIRECTORY_SEPARATOR. 'view\accueil.php';


}); 
$router->map( 'GET', '/jeu', function() {
    echo 'nous contacter';
});

$match = $router->match();

// call closure or throw 404 status
if( $match && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}    */