<?php

namespace Database;

use \PDO;

abstract class Connection
{

    //local db
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "scandiweb";

// //remote db
// //private $servername = "localhost";
// //private $username = "id19219278_ziad";
// //private $password = "Cc1234567#";
// //private $dbname = "id19219278_ziad";
    protected static $_db;

    private function setDb()
    {
        self::$_db = new PDO('mysql:host='.$this->servername.';dbname='.$this->dbname.';charset=utf8',$this->username,$this->password);
        self::$_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);
    }

    protected function getDb ()
    {
        if (self::$_db == null)
            $this->setDb();
        return self::$_db;
    }
}

?>