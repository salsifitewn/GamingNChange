<?php

/*Sert de fourre-tout singleton pattern


*/

class App
{
    //private $settings=[];

    private static $_instance;

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }


    public static function getTable($name)
    {

        $class_name  = 'App\Table\'' . ucfirst($name) . 'Table';
        return new $class_name();
    }
}