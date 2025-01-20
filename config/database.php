<?php

namespace App\Config;

class Database
{
    private static $pdo;

    public static function connect()
    {
        if (!self::$pdo) {
            // Read database config
            $config = require_once __DIR__ . '/../config/connection.php';

            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            $username = $config['username'];
            $password = $config['password'];

            // Create PDO instance
            self::$pdo = new PDO($dsn, $username, $password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
    }

    public static function execute($query, $params = [])
    {
        $stmt = self::connect()->prepare($query);
        return $stmt->execute($params);
    }

    public static function fetchAll($query, $params = [])
    {
        $stmt = self::connect()->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
