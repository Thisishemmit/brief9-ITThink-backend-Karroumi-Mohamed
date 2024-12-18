<?php
function create_database()
{
    $db_config = require "app/config/database.php";
    echo '<pre>';
    var_dump($db_config);
    echo '</pre>';

    $pdo = null;
    try {
        $pdo = new PDO(
            "mysql:host={$db_config['host']}; dbname={$db_config['database']}",
            $db_config['username'],
            $db_config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        $pdo->exec("CREATE DATABASE IF NOT EXISTS {$db_config['database']}");

    } catch (PDOException $e) {
        die($e->getMessage());
    }
    return $pdo;
}
