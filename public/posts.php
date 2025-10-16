<?php //this is posts.php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['headline'], $_POST['postContent'])) {
    header('Content-Type: application/json');

    $headline = $_POST['headline'];
    $post = $_POST['postContent'];
    $authorId = 1; // TODO: Replace with logged-in user ID (hardcoded for now)

    if ($headline === '' || $post === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Form cannot be empty']);
        exit;
    }

    // Insert post into DB
    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO post (headline, postContent, author, imgPath, createdAt) VALUES (?, ?, ?, 'missing.jpg', DATE_ADD(NOW(),interval 2 hour))");
        $stmt->execute([$headline, $post, $authorId]);

        echo json_encode(['success' => true, 'message' => 'post submitted']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save post']);
    }

    exit;
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

require_once 'pages/posts.html';
