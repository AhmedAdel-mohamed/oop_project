<?php

require __DIR__ . '/../src/Database.php';

try{
    $pdo = Database::getConnection();
    echo "Database connection successful.";
}catch (PDOException $e){
    echo "Database connection failed: " . $e->getMessage();
}

?>