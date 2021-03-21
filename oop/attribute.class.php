<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/model.class.php";
require_once __DIR__ . "/query.class.php";

class Attribute extends Model
{
    public function __construct($id = null)
    {
        parent::__construct("attributes", $id);
    }

    public function ofPlace($idPlace)
    {
        $query = "
          SELECT
            a.name, a.value, a.after
          FROM $this->_table a
          WHERE
                a.idPlace = $idPlace
            AND a.deleted = 0
        ";
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
