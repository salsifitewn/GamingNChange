<?php
// page test fonction
$jsonStr = file_get_contents("config.json");
$config = json_decode($jsonStr,true);
$database = $config['database'];
define("HOSTNAME", $database['host']);        
define("DBNAME", $database['dbname']);        
define("USER", $database['user']);        
define("PASS", $database['password']);

var_dump(HOSTNAME);
