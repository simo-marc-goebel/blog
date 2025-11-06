<?php

namespace SimoMarcGoebel\Blog\PostDetails;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\JsonResponse;
use PDO;

class postDetailHandler
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getPDO();
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $method = $request->getMethod();

        if ($method === 'POST') {
            return $this->handlePost($request);
        }

        if ($method === 'GET') {
            return $this->handleGet($request);
        }

        return new JsonResponse(['error' => 'Method not allowed'], 405);
    }

    private function handlePost(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        $comment = $data['comment'] ?? '';
        $postID = isset($data['post_id']) ? (int) $data['post_id'] : 0;
        $authorId = 1; // TODO: replace with logged-in user ID

        if (trim($comment) === '') {
            return new JsonResponse(['error' => 'Comment cannot be empty'], 400);
        }

        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO comment (commentContent, parentPost, author, createdAt) 
                 VALUES (?, ?, ?, DATE_ADD(NOW(), interval 2 hour))"
            );
            $stmt->execute([$comment, $postID, $authorId]);

            return new JsonResponse(['success' => true, 'message' => 'Comment submitted']);
        } catch (PDOException $e) {
            return new JsonResponse(['error' => 'Failed to save comment'], 500);
        }
    }

    private function handleGet(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        if (!isset($queryParams['id'])) {
            return new JsonResponse(['error' => 'No post ID specified'], 400);
        }

        $postID = (int) $queryParams['id'];

        $post = $this->sqlQuerySingle(
            "SELECT * FROM post p 
             LEFT JOIN user u ON u.id = p.author 
             LEFT JOIN role r ON r.id = u.roleid 
             WHERE p.id = ?",
            [$postID]
        );

        $comments = $this->sqlQueryAll(
            "SELECT * FROM comment c 
             LEFT JOIN user u ON u.id = c.author 
             LEFT JOIN role r ON r.id = u.roleid 
             WHERE c.parentPost = ? 
             ORDER BY createdAt DESC",
            [$postID]
        );

        return new JsonResponse([
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    private function sqlQuerySingle(string $query, array $params = []): array|false
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function sqlQueryAll(string $query, array $params = []): array
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
}