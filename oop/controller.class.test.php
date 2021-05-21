<?php

require_once __DIR__ . "/test.php";
require_once __DIR__ . "/controller.class.php";

echo "Start test controller.class.test.php" . PHP_EOL;

test(
    "Create object",
    boolval(new Controller()),
    true
);

echo "End test controller.class.test.php" . PHP_EOL;
