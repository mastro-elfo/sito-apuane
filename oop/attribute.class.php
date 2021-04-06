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
            ->select(["a.id", "at.name", "at.keyname", "a.value", "a.after"])
            ->from("$this->_table a")
            ->join("attrtypes at", "at.id = a.idAttrtype")
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
            ->select(["id", "name", "keyname"])
            ->from("attrtypes")
            ->where("deleted = 0")
            ->order("name ASC");
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
