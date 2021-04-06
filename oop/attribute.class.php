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

    public function ofPlace($idPlace)
    {
        $query = (new Query)
            ->select(["a.id", "a.name", "a.value", "a.after"])
            ->from("$this->_table a")
            ->where("a.idPlace = $idPlace")
            ->and("a.deleted = 0");
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function names()
    {
        $query = (new Query)
            ->select(["SUBSTRING(COLUMN_TYPE,5) as names"])
            ->from("information_schema.COLUMNS")
            ->where("TABLE_SCHEMA='apuane'")
            ->and("TABLE_NAME='attributes'")
            ->and("COLUMN_NAME='name'");
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_assoc();
        }
        return [];
    }
}
