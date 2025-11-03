<?php
session_start();

$lgnEmail = $_POST['email'];
$lgnPassword = $_POST['password'];

// Gets the user data for the given email address
$uData = sqlQuerySingle("SELECT u.*, r.rolename AS rolename FROM user u LEFT JOIN role r ON u.roleid = r.id WHERE u.email = ?", [$lgnEmail]);
if (!$uData) {
    echo json_encode(['success' => false, 'error' => 'User not found']);
    exit;
}
// Checks if the given lgnPassword is the same as the saved pw for the user
if ($uData['password'] !== $lgnPassword) {
    echo json_encode(['success' => false, 'error' => 'Invalid password']);
    exit;
}

// Passes necessary user Data to frontend - mostly for display
echo json_encode([
    'success' => true,
    'name' => $uData['name'],
    'email' => $uData['email'],
    'rolename' => $uData['rolename'],
    'id' => $uData['id']
]);

// returns single row
function sqlQuerySingle($query, $params = []) {
    $pdo = getPDO();
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetch();
}

// Builds the db con
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