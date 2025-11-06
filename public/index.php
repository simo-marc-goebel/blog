<?php
require_once '../vendor/autoload.php';

use Laminas\Diactoros\ServerRequestFactory;
use SimoMarcGoebel\Blog\Handler\CalculatorHandler;
use SimoMarcGoebel\Blog\Handler\RoadHandler;
use HttpSoft\Emitter\SapiEmitter;

$request = ServerRequestFactory::fromGlobals();
$path = $request->getUri()->getPath();

switch ($path) {
    case '/road':
        $handler = new RoadHandler();
        break;
    case '/calculator':
        $handler = new CalculatorHandler();
        break;
    case '/postDetails':
        $handler = new postDetailHandler();
        break;
    default:
        $handler = new RoadHandler();
        echo "test";
        break;
}

$response = $handler->handle($request);

$emitter = new SapiEmitter();
$emitter->emit($response);
