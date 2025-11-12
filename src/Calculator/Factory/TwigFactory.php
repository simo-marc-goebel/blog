<?php

namespace SimoMarcGoebel\Blog\Calculator\Factory;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigFactory
{
    public function __invoke()
    {
        $path = __DIR__ . "/../Templates";
        $loader = new FilesystemLoader($path);
        $twig = new Environment($loader, [
            'cache' => false,
        ]);
        return $twig;
    }
}