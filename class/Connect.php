<?php
// function to connect to the database with mysql and PDO
namespace App;

class Connect
{
    public static function db_connect()
    {
        try {
            $jsonStr = file_get_contents(dirname(__DIR__) . DIRECTORY_SEPARATOR . "config.json"); //Recupère les infos de connection
            $config = json_decode($jsonStr, true);
            $database = $config['database'];
            define("HOSTNAME", $database['host']);
            define("DBNAME", $database['dbname']);
            define("USER", $database['user']);
            define("PASS", $database['password']);
            $pdo = new \PDO('mysql:hostname=' . HOSTNAME . 'charset=utf-8;dbname=' . DBNAME, USER, PASS);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\Exception $e) {
            $e->getMessage();
            echo $e;
        }

        // if the connection is successful , we have the connection in the $pdo variable
        // if($pdo){
        // echo "connected!";
        // }
        //returning the connection in the $pdo variable so its usable in the init script

    } // END db_connect();



}
