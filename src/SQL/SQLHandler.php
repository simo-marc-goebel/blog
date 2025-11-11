<?php

namespace SimoMarcGoebel\Blog\SQL;

use PDO;

class SQLHandler
{
    public function __construct(){
    }
    public function sqlQuerySingle($query, $params = []) {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(); // returns single row
    }

// Function to fetch multiple rows
    function sqlQueryAll($query, $params = []) {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(); // returns array of rows
    }
    public function sqlInsert($query, $params = []) {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
    }

// PDO connection
    function getPDO() {
        $host = 'db'; $db = 'blog'; $user = 'root'; $pass = 'root'; $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        try {
            return new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            echo json_encode(['error' => 'Database connection failed']);
            exit;
        }
    }
}