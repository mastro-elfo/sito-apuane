<?php
require_once __DIR__ . "/test.php";
require_once __DIR__ . "/query.class.php";

echo "Start test query.class.test.php" . PHP_EOL;

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
    "Create query short",
    (new Query)->insert("table", [
        "id"   => 0,
        "name" => "'name'",
    ]),
    "INSERT INTO table (id, name) VALUES (0, 'name')"
);

test(
    "Read query",
    (new Query)
        ->select(["id", "name"])
        ->from("table")
        ->where("id = 0")
        ->and("deleted = 0")
        ->order("main DESC"),
    "SELECT id, name FROM table WHERE id = 0 AND deleted = 0 ORDER BY main DESC"
);

test(
    "Read query short",
    (new Query)
        ->select(["id", "name"], "table", ["id = 0", "deleted = 0"])
        ->order("main DESC"),
    "SELECT id, name FROM table WHERE id = 0 AND deleted = 0 ORDER BY main DESC"
);

test(
    "Join query",
    (new Query)
        ->select(["t.id", "t.name"])
        ->from("table t")
        ->join("other o", "o.tableId = t.id")
        ->where("t.id = 0")
        ->and("t.deleted = 0"),
    "SELECT t.id, t.name FROM table t INNER JOIN other o ON o.tableId = t.id WHERE t.id = 0 AND t.deleted = 0"
);

test(
    "Join Join query short",
    (new Query)
        ->select(["t.id", "t.name"], "table t", ["t.id = 0", "t.deleted = 0"])
        ->join("other o", "o.tableId = t.id"),
    "SELECT t.id, t.name FROM table t INNER JOIN other o ON o.tableId = t.id WHERE t.id = 0 AND t.deleted = 0"
);

test(
    "Left Join query",
    (new Query)
        ->select(["t.id", "t.name"])
        ->from("table t")
        ->left("other o", "o.tableId = t.id")
        ->where("t.id = 0")
        ->and("t.deleted = 0"),
    "SELECT t.id, t.name FROM table t LEFT JOIN other o ON o.tableId = t.id WHERE t.id = 0 AND t.deleted = 0"
);

test(
    "Left Join query short",
    (new Query)
        ->select(["t.id", "t.name"], "table t", ["t.id = 0", "t.deleted = 0"])
        ->left("other o", "o.tableId = t.id"),
    "SELECT t.id, t.name FROM table t LEFT JOIN other o ON o.tableId = t.id WHERE t.id = 0 AND t.deleted = 0"
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
    "Update query short",
    (new Query)
        ->update("table", [
            "name"   => "'new name'",
            "number" => 1,
            "string" => "'str'",
        ], ["id = 0", "deleted = 0"]),
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

test(
    "Delete query short",
    (new Query)->delete("table", "id = 0"),
    "DELETE FROM table WHERE id = 0"
);

echo "End test query.class.test.php" . PHP_EOL;
