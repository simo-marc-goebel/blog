<?php

namespace SimoMarcGoebel\Blog\InsertHandler;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SimoMarcGoebel\Blog\SQL\Comment\Comment;
use SimoMarcGoebel\Blog\SQL\SQLHandler;

class InsertComment
{
    private Comment $comment;
    private SQLHandler $sql;
    public function __construct(Comment $comment){
        $this->comment = $comment;
        $this->sql = new SQLHandler();
    }
    function getComment(ServerRequestInterface $request): Response{
        if ($request->getMethod() === 'POST') {
            // Get POST data as an associative array
            $data = $request->getParsedBody();

            $this->comment->comment = trim($data['comment']);
            $this->comment->commentAuthor = trim($data['user_id']);
            $this->comment->parentPost = trim($data['post_id']);

            if ($this->insertComment()) {
                return new HtmlResponse(json_encode(['success' => true]), 200, [
                    'Content-Type' => 'application/json'
                ]);
            } else {
                return new HtmlResponse(json_encode(['success' => false, 'error' => 'DB insert failed']), 500, [
                    'Content-Type' => 'application/json'
                ]);
            }
        }

        return new HtmlResponse('Invalid request method');
    }

    public function insertComment(): bool{
        $stmt = "INSERT INTO comment (commentContent, author, parentPost)
                 VALUES (?, ?, ?)";

        try {
            $params = [
                $this->comment->comment,
                $this->comment->commentAuthor,
                (int)$this->comment->parentPost
            ];
            $this->sql->sqlInsert($stmt, $params);
            return true;
        } catch (\PDOException $e) {
            // log $e->getMessage() somewhere appropriate
            return false;
        }
    }
}