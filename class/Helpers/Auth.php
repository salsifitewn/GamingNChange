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
    public static function forcer_utilisateur_connecte()
    {
        if (!self::est_connecte() ) {
            header('Location: /login');
            exit();
        }
    }
    public static function est_admin():bool
    {
        self::est_connecte();
        return ($_SESSION['role']==0);
        
    }

}
