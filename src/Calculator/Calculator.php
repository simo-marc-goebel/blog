<?php

namespace SimoMarcGoebel\Blog\Calculator;
class Calculator
{
    function calculate(float $a,float $b, string $op) : float | string{
        switch ($op) {
            case '+':
                return $a + $b;
            case '-':
                return $a - $b;
            case '*':
                return $a * $b;
            case '/':
                return ($b != 0) ? $a / $b : 'Error: Division by zero';
            default:
                return 'Error: Invalid operator';
        }
    }
}