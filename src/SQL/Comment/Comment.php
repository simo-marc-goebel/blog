<?php

namespace SimoMarcGoebel\Blog\SQL\Comment;


use SimoMarcGoebel\Blog\SQL\User\User;

class Comment
{
    public string $comment;
    public User|int $commentAuthor;
    public string $createdAt; //TODO Convert to DateTime / Timestamp
    public int $parentPost;

    public function __construct(string $comment, User|int $commentAuthor, string $createdAt, int $parentPost){
        $this->comment = $comment;
        $this->commentAuthor = $commentAuthor;
        $this->createdAt = $createdAt;
        $this->parentPost = $parentPost;
    }
}