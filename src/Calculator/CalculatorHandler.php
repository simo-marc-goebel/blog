<?php

namespace SimoMarcGoebel\Blog\Calculator;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SimoMarcGoebel\Blog\Handler\RenderHandler;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class CalculatorHandler
{
    private RenderHandler $renderer;

    public function __construct()
    {
        $this->renderer = new RenderHandler("Calculator");
    }
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $a = $queryParams['a'] ?? null;
        $b = $queryParams['b'] ?? null;
        $op = isset($queryParams['op']) ? str_replace(' ', '+', $queryParams['op']) : null;

        $result = null;
        if ($a !== null && $b !== null && $op !== null) {
            $calculator = new Calculator();
            $result = $calculator->calculate($a, $b, $op);
        }
        // twig
        $loader = new FilesystemLoader('../src/Calculator/Templates');
        $twig = new Environment($loader, [
            'cache' => false,
        ]);

        return $this->renderer->handle($request, 'calculator.twig', [
            'a' => $a,
            'b' => $b,
            'op' => $op,
            'result' => $result,
        ]);
    }
}