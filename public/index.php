<?php
require_once '../vendor/autoload.php';

use HttpSoft\Emitter\SapiEmitter;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequestFactory;
use SimoMarcGoebel\Blog\Routes;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$routes = Routes::getRoutes();

// Request and Context
$request = ServerRequestFactory::fromGlobals();
$context = new RequestContext();
$context->setPathInfo($request->getUri()->getPath()); // path
$context->setMethod($request->getMethod());           // HTTP method
$context->setHost($request->getUri()->getHost());     // host
$context->setScheme($request->getUri()->getScheme()); // scheme (http/https)

// Match the current path
$matcher = new UrlMatcher($routes, $context);

try {
    $parameters = $matcher->match($request->getUri()->getPath());
    $handlerClass = $parameters['_handler']; // Execute the given handler in the routecollection
    $handler = new $handlerClass();
    $response = $handler->handle($request);
}
catch (ResourceNotFoundException $e) {
    $response = new HtmlResponse('404 - Page not found', 404);
}
catch (Exception $e) {
    $response = new HtmlResponse('500 - Internal Server Error' . $e->getMessage(), 500);
}

$emitter = new SapiEmitter();
$emitter->emit($response);
