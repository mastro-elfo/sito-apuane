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

    public function ofPlace($idPlace)
    {
        $query = "
          SELECT
            t.id, t.name, t.color, t.textColor
          FROM $this->_table t
          INNER JOIN places_tags pt ON pt.idTag = t.id
          WHERE
                pt.idPlace = $idPlace
            AND t.deleted = 0
            AND pt.deleted = 0
          ORDER BY t.name ASC
        ";
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
