<?php
namespace Base;

class DB {

    static function connect() {
        $db = new \PDO(
                'mysql:host=' . DB_HOST . ';port='.DB_PORT.';dbname=' . DB_NAME,DB_USER, DB_PASS
        );
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);    
        $db->query("SET TIME_ZONE = '-03:00'");
        $db->query("SET sql_mode = ''");
        return $db;
    }

}
