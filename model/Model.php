<?php
// C:\wamp64\www\ma_mangatheque\model\Model.php
abstract class Model {
    private static $db; // PDO bağlantı nesnesini tutar

    // Veritabanı bağlantısını kurar (sadece bir kez çağrılır)
    private static function setDb(){
        $host = 'localhost';
        $dbName = 'ma_mangatheque'; 
        $user = 'root';
        $pass = 'root'; 
        $charset = 'utf8mb4'; 

        $dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,     
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,           
            PDO::ATTR_EMULATE_PREPARES   => false,                      
        ];

        try {
            self::$db = new PDO($dsn, $user, $pass, $options);
        } catch(PDOException $e) {
            error_log("Erreur de database: " . $e->getMessage());
            die("Erreur de database: Veuillez vérifier les paramètres de connexion."); 
        }
    }

    // Veritabanı bağlantı nesnesini döndürür
    protected function getDb(){
        if(self::$db === null){
            self::setDb();
        }
        return self::$db;
    }
}