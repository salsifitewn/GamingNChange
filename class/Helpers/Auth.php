<?php
namespace App\Helpers;

class Auth
{

    public static function est_connecte(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return !empty($_SESSION['connecte']);
    }
    public static function forcer_utilisateur_connecte(?string $url=null)
    {
        if (!self::est_connecte() && isset($_SESSION['role']) && (int)$_SESSION['role'] == 0) {
            header('Location: /login');
            exit();
        }
    }
  

}
