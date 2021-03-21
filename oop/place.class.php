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

    public function read($columns = null)
    {
        return parent::read(
            is_null($columns)
            ? ["id", "name", "title", "description", "article", "!isnull(image) as image", "uDateTime"]
            : $columns
        );
    }

    public function search($string)
    {
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
            " . ($string ? "AND name LIKE '%$string%'" : "") . "
          ORDER BY p.name ASC
        ";
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }

    public function related()
    {
        $query = "
          SELECT
            o.id, o.name
          FROM places o
          INNER JOIN places_places pp ON pp.idTo = o.id
          WHERE pp.idFrom = $this->_id
            AND pp.deleted = 0
            AND o.deleted = 0
          ORDER BY o.name ASC
        ";
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }

    public function tags()
    {
        $query = "
          SELECT
            t.id, t.name, t.color, t.textColor
          FROM tags t
          INNER JOIN places_tags pt ON pt.idTag = t.id
          WHERE
                pt.idPlace = $this->_id
            AND t.deleted = 0
            AND pt.deleted = 0
          ORDER BY t.name ASC
        ";
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }

    public function attributes()
    {
        $query = "
          SELECT
            a.name, a.value, a.after
          FROM attributes a
          WHERE
                a.idPlace = $this->_id
            AND a.deleted = 0
        ";
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }

    public function latest($offset, $count)
    {
        $query = (new Query)
            ->select(["id", "name", "description", "title", "!isnull(image) as image", "uDateTime"])
            ->from($this->_table)
            ->where("deleted = 0")
            ->order(["uDateTime" => "DESC"])
            ->limit($offset, $count);
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
