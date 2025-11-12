<?php

namespace SimoMarcGoebel\Blog\Calculator;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

readonly class CalculatorHandler
{
    public function __construct(private Environment $twig, private Calculator $calculator)
    {

    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $a = $queryParams['a'] ?? null;
        $b = $queryParams['b'] ?? null;
        $op = isset($queryParams['op']) ? str_replace(' ', '+', $queryParams['op']) : null;

        $result = null;
        if ($a !== null && $b !== null && $op !== null) {
            $result = $this->calculator->calculate($a, $b, $op);
        }
        $html = $this->twig->render('calculator.twig', [
            'a' => $a,
            'b' => $b,
            'op' => $op,
            'result' => $result,
        ]);
        return new HtmlResponse($html);

    }
}