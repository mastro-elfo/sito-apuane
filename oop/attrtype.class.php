<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/model.class.php";
require_once __DIR__ . "/query.class.php";

class AttrType extends Model
{
    public function __construct($id = null)
    {
        parent::__construct("attrtypes", $id);
    }

    public function all()
    {
        $query = (new Query)
            ->select(["id", "name", "keyname", "uDateTime"])
            ->from($this->_table)
            ->where("deleted = 0");
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
