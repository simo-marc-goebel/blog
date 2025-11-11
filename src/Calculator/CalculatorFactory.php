<?php

namespace SimoMarcGoebel\Blog\Calculator;

class CalculatorFactory
{
    public function __construct(int $a, int $b, string $operator){
        $this->create($a, $b, $operator);
    }
    public static function create($a, $b, $operator)
    {
        $calc  = new Calculator();
        echo $calc->calculate($a, $b, $operator);
        return;
    }
}