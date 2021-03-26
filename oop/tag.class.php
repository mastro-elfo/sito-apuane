<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/model.class.php";
require_once __DIR__ . "/query.class.php";

class Tag extends Model
{
    public function __construct($id = null)
    {
        parent::__construct("tags", $id);
    }

    public function ofPlace($idPlace, $columns = [])
    {
        $query = (new Query)
            ->from("$this->_table t")
            ->join("places_tags pt", "pt.idTag = t.id")
            ->where("pt.idPlace = $idPlace")
            ->and("t.deleted = 0")
            ->and("pt.deleted = 0")
            ->order(["t.name" => "ASC"]);
        if ($columns) {
            $query->select(array_map(
              fn($c) => "t.$c",
              $columns
            ));
        } else {
            $query->select(["t.id", "t.name", "t.color", "t.textColor"]);
        }
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
