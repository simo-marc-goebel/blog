<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'], $_POST['post_id'])) {
    header('Content-Type: application/json');

    $comment = $_POST['comment'];
    $postID = $_POST['post_id'] ? (int) $_POST['post_id'] : 0;
    $authorId = 1; // TODO: Replace with logged-in user ID (hardcoded for now)

    if ($comment === '') { // handled by both js and html - only for redundancy
        http_response_code(400);
        echo json_encode(['error' => 'Comment cannot be empty']);
        exit;
    }

    // Insert comment into DB
    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO comment (commentContent, parentPost, author, createdAt) VALUES (?, ?, ?, DATE_ADD(NOW(),interval 2 hour))");
        $stmt->execute([$comment, $postID, $authorId]);

        echo json_encode(['success' => true, 'message' => 'Comment submitted']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo 'Failed to save comment: ' . $e->getMessage();
        echo json_encode(['error' => 'Failed to save comment']);
    }

    exit;
}

if (isset($_GET['id'])) {
    header('Content-Type: application/json');
    $currentPostID = (int)$_GET['id']; // cast to int for safety

    $post = sqlQuerySingle("SELECT * FROM post p LEFT JOIN user u ON u.id = p.author LEFT JOIN role r ON r.id = u.roleid WHERE p.id = ?", [$currentPostID]);
    $comments = sqlQueryAll("SELECT * FROM comment c LEFT JOIN user u ON u.id = c.author LEFT JOIN role r ON r.id = u.roleid WHERE c.parentPost = ? ORDER BY createdAt DESC", [$currentPostID]);
    // Give the queried data to frontend
    echo json_encode([
        'post' => $post,
        'comments' => $comments
    ]);
} else {
    // No id specified, return empty or error JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No post ID specified']);
}

// Function to fetch one row
function sqlQuerySingle($query, $params = []) {
    $pdo = getPDO();
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetch(); // returns single row
}

// Function to fetch multiple rows
function sqlQueryAll($query, $params = []) {
    $pdo = getPDO();
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(); // returns array of rows
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
?>