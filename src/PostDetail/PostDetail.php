<?php

namespace SimoMarcGoebel\Blog\PostDetail;

use SimoMarcGoebel\Blog\SQL\Post\Post;
use SimoMarcGoebel\Blog\SQL\SQLHandler;
use SimoMarcGoebel\Blog\SQL\User\User;
use SimoMarcGoebel\Blog\SQL\Comment\Comment;

class PostDetail
{

    public Post $post;
    public User $author;
    public array $comments = [];
    private SQLHandler $sql;

    public function __construct(int $postId)
    {
        $this->sql = new SQLHandler();
        $this->post= $this->fetchPost($postId);
        $this->fetchComments($postId);
    }

    private function fetchPost(int $postID): Post
    {
        $row = $this->sql->sqlQuerySingle(
            "SELECT 
                    p.id AS p_id, 
                    p.headline AS p_headline, 
                    p.postContent AS p_postContent, 
                    p.imgPath AS p_imgPath,
                    p.createdAt AS p_createdAt, 
                    p.country AS p_country, 
                    u.id AS u_id, 
                    u.name AS u_name, 
                    u.email AS u_email, 
                    u.roleid AS u_roleid, 
                    u.profilePic AS u_profilePic
                    FROM post p 
                    INNER JOIN user u ON p.author = u.id 
                    WHERE p.id = ?",
            [$postID]
        );
            //Prepare User to be fed into Post as author
        $author = new User($row['u_name'], $row['u_email'], $row['u_roleid'], $row['u_profilePic']);
        $this->post = new Post($row['p_id'], $row['p_headline'], $row['p_postContent'], $row['p_imgPath'], $row['p_createdAt'], $author, $row['p_country']);
        return $this->post;
    }

    private function fetchComments(int $postID)
    {
        $rows = $this->sql->sqlQueryAll("SELECT 
                                                c.commentContent AS c_commentContent, 
                                                c.createdAt AS c_createdAt, 
                                                c.parentPost AS c_parentPost, 
                                                u.id AS u_id, 
                                                u.name AS u_name, 
                                                u.email AS u_email, 
                                                u.roleID AS u_roleID, 
                                                u.profilePic AS u_profilePic 
                                                FROM comment c 
                                                INNER JOIN user u ON c.author = u.id 
                                                WHERE c.parentPost = ?", [$postID]);

        $this->comments = []; // reset comments array

        foreach ($rows as $row) {
                // Prepares User to be fed into each Comment as Author
            $user = new User($row['u_name'], $row['u_email'], $row['u_roleID'], $row['u_profilePic']);
            $comment = new Comment($row['c_commentContent'],$user, $row['c_createdAt'], $row['c_parentPost']);
                // Appends current Comment to array
            $this->comments[] = $comment;
        }
    }
}