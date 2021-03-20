<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/model.class.php";
require_once __DIR__ . "/query.class.php";

class Place extends Model
{
    public function __construct($id = null)
    {
        parent::__construct("places", $id);
    }

    public function search($string)
    {
        $query = (new Query)
            ->select(["id", "name"])
            ->from($this->_table)
            ->where("name LIKE '%$string%'");
        $ret = $this->_db->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
}
