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

    public function read($columns = null){
      return parent::read(
        is_null($columns)
        ? ["id", "name", "title", "description", "article", "!isnull(image) as image", "uDateTime"]
        : $columns
      );
    }

    public function search($string)
    {
        // $query = (new Query)
        //     ->select(["id", "name"])
        //     ->from($this->_table)
        //     ->where("(name LIKE '%$string%' OR description LIKE '%$string%')")
        //     ->and("deleted = 0");
        $query = "
          SELECT
            p.id, p.name, p.title,
            (SELECT
              GROUP_CONCAT(t.name, '/', t.color, '/', t.textColor
                SEPARATOR ',')
            FROM tags t
            INNER JOIN places_tags pt ON pt.idTag = t.id
            WHERE pt.idPlace = p.id
            ORDER BY t.name ASC) AS tags
          FROM `$this->_table` p
          WHERE p.deleted = 0
            ".($string ? "AND name LIKE '%$string%'" : "")."
          ORDER BY p.name ASC
        ";
        $ret = $this->_db->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
}
