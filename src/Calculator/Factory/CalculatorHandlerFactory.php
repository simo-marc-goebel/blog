<?php

namespace SimoMarcGoebel\Blog\Calculator\Factory;

use SimoMarcGoebel\Blog\Calculator\Calculator;
use SimoMarcGoebel\Blog\Calculator\CalculatorHandler;
use SimoMarcGoebel\Blog\Container\SimpleContainer;
use Twig\Environment;

readonly class CalculatorHandlerFactory
{
    public function __construct(private SimpleContainer $container){

    }

    public function __invoke(): CalculatorHandler
    {

        $twig = $this->container->get(Environment::class);
        $calc = $this->container->get(Calculator::class);
        return new CalculatorHandler($twig, $calc);
    }
}