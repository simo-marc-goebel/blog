<?php

namespace SimoMarcGoebel\Blog\Handler;

use HttpSoft\Emitter\SapiEmitter;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class RenderHandler
{
    private Environment $twig;

    /**
     * @param string $templateDir Tells the Filesystem Loader where to find the template file TODO: Dynamic routing
     */
    public function __construct(string $templateDir)
    {
        $path = "../src/" . $templateDir . "/Templates"; // Full path
        $loader = new FilesystemLoader($path);
        $this->twig = new Environment($loader, [
            'cache' => false,
        ]);
    }
    public function handle(ServerRequestInterface $request, string $template, array $args = []): ResponseInterface
    {
        $html = $this->twig->render($template, $args);

        return new HtmlResponse($html);
    }
}