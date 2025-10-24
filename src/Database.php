<?php

namespace App;

use PDO;

class Database {
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null){
            $host = '127.0.0.1'; // استخدم 127.0.0.1 بدل localhost
            $dbname = 'oop_project';
            $user = 'root';
            $password = '';
            $options = [ // صححت typo
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            self::$pdo = new PDO($dsn, $user, $password, $options);
        }
        return self::$pdo;      
    }
}
?>
