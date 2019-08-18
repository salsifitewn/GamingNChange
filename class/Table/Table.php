<?php

/*Factory class

*/
namespace App\Table;

class Table

{

    protected $table;

    public function __contruct() //
    {
        if (is_null($this->table)) {

            $parts = explode('\\', get_class($this));
            $class_name = end($parts);
            $this->table = strtolower(str_replace('Table', '', $class_name));
        }
    }
}
