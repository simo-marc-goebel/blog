<?php

namespace SimoMarcGoebel\Blog\PostDetail;

use Psr\Http\Message\ServerRequestInterface;
use SimoMarcGoebel\Blog\CurrentPostHandler\CurrentPostHandler;
use SimoMarcGoebel\Blog\Handler\RenderHandler;

class PostDetailHandler
{
    public PostDetail $postDetail;

    private RenderHandler $renderer;
    private CurrentPostHandler $postHandler;

    public function __construct()
    {
        $this->renderer = new RenderHandler("PostDetail");
        $this->postHandler = new CurrentPostHandler();
    }
    public function handle(ServerRequestInterface $request){
        $postID = $this->postHandler->getCurrentPost($request);
        $this->postDetail = new PostDetail($postID);

        return $this->renderer->handle($request, 'postDetails.twig', [
            'post' => $this->postDetail->post,
            'comments' => $this->postDetail->comments,
        ]);
    }

}