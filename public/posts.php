<?php //this is posts.php

require_once 'pages/posts.html';


function sqlQuery($query) {
    $host = 'db'; $db = 'blog'; $user = 'root'; $pass = 'root'; $charset = 'utf8mb4';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $stmt = $pdo->query("$query");
    return $stmt;
} catch (\PDOException $e) {
    echo 'There was an error in the db: ' . $e->getMessage();
    return [];
}
}
