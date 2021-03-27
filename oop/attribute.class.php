<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/model.class.php";
require_once __DIR__ . "/query.class.php";

class MyAttribute extends Model
{
    public function __construct($id = null)
    {
        parent::__construct("attributes", $id);
    }

    public function ofPlace($idPlace, $columns = [])
    {
        $query = (new Query)
            ->from("$this->_table a")
            ->where("a.idPlace = $idPlace")
            ->and("a.deleted = 0");
        if ($columns) {
            $query->select(array_map(fn($c) => "a.$c", $columns));
        } else {
            $query->select(["a.id", "a.name", "a.value", "a.after"]);
        }
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
