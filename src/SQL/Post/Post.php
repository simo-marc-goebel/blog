<?php

namespace SimoMarcGoebel\Blog\SQL\Post;
use SimoMarcGoebel\Blog\SQL\User\User;

class Post
{
    public int $id;
    public string $headline;
    public string $content;
    public string $imgPath;
    public string $createdAt;
    public User|int $author;
    public string $country;

    public function __construct(int $id, string $headline, string $content, string $imgPath, string $createdAt, User|int $author, string $country)
    {
        $this->id = $id;
        $this->headline = $headline;
        $this->content = $content;
        $this->imgPath = $imgPath;
        $this->createdAt = $createdAt;
        $this->author = $author;
        $this->country = $country;

    }
}