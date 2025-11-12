<?php

namespace SimoMarcGoebel\Blog\UnitTests;

use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use SimoMarcGoebel\Blog\Calculator\Factory\CalculatorHandlerFactory;

class CalculatorHandlerTest extends TestCase
{
    private static $a = 1;
    private static $b = 2;
    private static $op = '+';
    public function testThatEmptyRequestLoadsCalculator(){
        $handler = (new CalculatorHandlerFactory(5,3,'+'));
        $request = new ServerRequest();
        $response = $handler->create($this->a, $this->b, $this->op);
        $this->assertStringContainsString('<h1>Simple Calculator</h1>', (string)$response->getBody());
    }
    public static function testThatAdditionWorks(){
        $handler = new CalculatorHandlerFactory(5,3,'+')->create(self::$a, self::$b, self::$op);
        $request = new ServerRequest();
        $response = $handler->handle($request);
        self::assertStringContainsString('<h1>Simple Calculator</h1>', (string)$response->getBody());
    }

}
