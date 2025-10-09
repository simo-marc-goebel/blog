<?php
//require_once 'indexold.html';

var_dump($_REQUEST);
function calculate($num1, $num2, $operator) {
    switch ($operator) {
        case '+':
            return $num1 + $num2;
        case '-':
            return $num1 - $num2;
        case '*':
            return $num1 * $num2;
        case '/':
            if ($num2 == 0) {
                return "Error: Division by zero";
            }
            return $num1 / $num2;
        case '%':
            return $num1 % $num2;
        default:
            return "Error: Invalid operator";
    }
}
$a = (int) $_REQUEST['a'];
$b = (int) $_REQUEST['b'];
$operator = $_REQUEST['operator'];
echo calculate($a, $b, $operator );