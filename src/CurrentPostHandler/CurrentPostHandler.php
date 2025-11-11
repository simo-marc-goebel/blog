<?php

namespace SimoMarcGoebel\Blog\CurrentPostHandler;

use Psr\Http\Message\ServerRequestInterface;

class CurrentPostHandler
{
    public function __construct(){

    }
    public function getCurrentPost(ServerRequestInterface $request): int
    {
        $queryParams = $request->getQueryParams();

        if (!isset($queryParams['post_id'])) {
            return -1; // Predefined missing post
        }

        return (int)$queryParams['post_id'];
    }
}