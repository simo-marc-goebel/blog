<?php
require_once 'pages/indexold.html';

function calculate(float|int|null $num1, float|int|null $num2, string|null $operator):float|int|string  {
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

if (isset($_REQUEST['a'], $_REQUEST['b'], $_REQUEST['operator'])) {
    $a = (int) $_REQUEST['a'];
    $b = (int) $_REQUEST['b'];
    $operator = $_REQUEST['operator'];

    echo '<br> The result of the URL Params: ' . $a . $operator . $b . ' is: ' . calculate($a, $b, $operator );
}
else{
    echo 'Error: One of the operators was null';
}
