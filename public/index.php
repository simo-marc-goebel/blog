<?php
require_once '../vendor/autoload.php';

use SimoMarcGoebel\Blog\Calculator\Calculator;
use Laminas\Diactoros\ServerRequestFactory;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

// Create request
$request = ServerRequestFactory::fromGlobals();
$queryParams = $request->getQueryParams();

// Initialize calculator
$calculator = new Calculator();

// Default values
$a = $queryParams['a'] ?? null;
$b = $queryParams['b'] ?? null;
$op = isset($queryParams['op']) ? str_replace(' ', '+', $queryParams['op']) : null;

$result = null;

// Only calculate if all params are present
if ($a !== null && $b !== null && $op !== null) {
    $result = $calculator->calculate($a, $b, $op);
}

// Twig setup
$loader = new FilesystemLoader('../src/Calculator/Templates');
$twig = new Environment($loader, [
    'cache' => false, // disable cache while developing
]);

$postParams = $request->getParsedBody();
$fname = $postParams['fname'] ?? null;
$lname = $postParams['lname'] ?? null;
$age = $postParams['age'] ?? null;
$nickname = $postParams['nickname'] ?? null;

// Render Twig template
echo $twig->render('calculator.twig', [
    // Get params here
    'a' => $a,
    'b' => $b,
    'op' => $op,
    'result' => $result,

    // Post params from here
    'fname' => $fname,
    'lname' => $lname,
    'age' => $age,
    'nickname' => $nickname,
]);
