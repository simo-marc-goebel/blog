<?php

namespace SimoMarcGoebel\Blog\Calculator;

interface CalculatorInterface
{
    public function calculate(float $a,float $b, string $op): float | string;
}