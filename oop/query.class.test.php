<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/query.class.php";

echo "zend.assertions = " . ini_get("zend.assertions") . PHP_EOL;
echo "Start test query.class.test.php" . PHP_EOL;

function test($title, $expression, $expected)
{
    assert(
        ((string) $expression) == $expected,
        "$title, Expected: \"$expected\", Got: \""
        . ((string) $expression) . '"'
    );
}

test(
    "Create query",
    (new Query)
        ->insert("table")
        ->values([
            "id"   => 0,
            "name" => "'name'",
        ])
    ,
    "INSERT INTO table (id, name) VALUES (0, 'name')"
);

test(
    "Read query",
    (new Query)
        ->select(["id", "name"])
        ->from("table")
        ->where("id = 0")
        ->and("deleted = 0"),
    "SELECT id, name FROM table WHERE id = 0 AND deleted = 0"
);

test(
    "Update query",
    (new Query)
        ->update("table")
        ->set([
            "name"   => "'new name'",
            "number" => 1,
            "string" => "'str'",
        ])
        ->where("id = 0")
        ->and("deleted = 0"),
    "UPDATE table SET name = 'new name', number = 1, string = 'str' WHERE id = 0 AND deleted = 0"
);

test(
    "Delete query",
    (new Query)
        ->delete()
        ->from("table")
        ->where("id = 0"),
    "DELETE FROM table WHERE id = 0"
);

echo "End test query.class.test.php" . PHP_EOL;
