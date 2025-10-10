<?php

//require_once 'pages/indexold.html';

var_dump($_REQUEST);
exit;
function calculate(float|int|null $num1, float|int|null $num2, string|null $operator):float|int|string  {
    if ($num1 == null || $num2 == null || $operator == null)
    {
        return "Error: One parameter was null";
    }
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
echo '<br> The result of the URL Params: ' . $a . $operator . $b . ' is: ' . calculate($a, $b, $operator );
