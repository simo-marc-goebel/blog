<?php

namespace SimoMarcGoebel\Blog;

use SimoMarcGoebel\Blog\Calculator\CalculatorHandler;
use SimoMarcGoebel\Blog\PostDetail\PostDetailHandler;
use SimoMarcGoebel\Blog\Road\RoadHandler;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Routes
{
    public static function getRoutes(): RouteCollection
    {
        $routes = new RouteCollection();

        $routes->add('home', new Route('/', ['_handler' => CalculatorHandler::class])); // DEFAULT / Home / Index route
        $routes->add('road', new Route('/road', ['_handler' => RoadHandler::class]));
        $routes->add('calculator', new Route('/calculator', ['_handler' => CalculatorHandler::class]));
        $routes->add('postDetails', new Route('/postDetails', ['_handler' => PostDetailHandler::class]));

        // Add routes

        return $routes;
    }
}