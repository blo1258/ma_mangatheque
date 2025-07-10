<?php

abstract class Database {
    private static $db;

    private static function setDb(){
        try {
            self::$db = new PDO('mysql:host=localhost;dbname=ma_mangatheque', 'root', 'root');
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function getDb(){
        if(self::$db == null){
            self::setDb();
        }

        return self::$db;
    }
}