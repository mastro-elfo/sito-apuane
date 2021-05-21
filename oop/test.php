<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function test($title, $expression, $expected)
{
    echo $title . PHP_EOL;
    assert(
        ((string) $expression) == $expected,
        "$title, Expected: \"$expected\", Got: \""
        . ((string) $expression) . '"'
    );
}
