<?php

use SimoMarcGoebel\Blog\Calculator\Calculator;
use SimoMarcGoebel\Blog\Calculator\CalculatorHandler;
use SimoMarcGoebel\Blog\Calculator\Factory\CalculatorHandlerFactory;
use SimoMarcGoebel\Blog\Calculator\Factory\TwigFactory;
use SimoMarcGoebel\Blog\Container\SimpleContainer;
use Twig\Environment;

return new SimpleContainer(
    [
        CalculatorHandler::class => CalculatorHandlerFactory::class,
        Environment::class => TwigFactory::class,
        Calculator::class => Calculator::class,
    ]
);