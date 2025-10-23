<?php
session_start();

$lgnEmail = $_POST['email'];
$lgnPassword = $_POST['password'];

$uData = sqlQuerySingle("SELECT u.*, r.rolename AS rolename FROM user u LEFT JOIN role r ON u.roleid = r.id WHERE u.email = ?", [$lgnEmail]);
if (!$uData) {
    echo json_encode(['success' => false, 'error' => 'User not found']);
    exit;
}

if ($uData['password'] !== $lgnPassword) {
    echo json_encode(['success' => false, 'error' => 'Invalid password']);
    exit;
}

echo json_encode([
    'success' => true,
    'name' => $uData['name'],
    'email' => $uData['email'],
    'rolename' => $uData['rolename'],
    'id' => $uData['id']
]);

function sqlQuerySingle($query, $params = []) {
    $pdo = getPDO();
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetch(); // returns single row
}

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