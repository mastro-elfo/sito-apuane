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

    public function search($string = null, $tag = null)
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
          " . ($tag ? "
          INNER JOIN places_tags pt ON pt.idPlace = p.id
          INNER JOIN tags t ON t.id = pt.idTag
          " : "") . "
          WHERE p.deleted = 0
            " . ($string ? "AND name LIKE '%$string%'" : "") . "
            " . ($tag ? "AND t.name = '$tag'" : "") . "
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
        return [];
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

    public function coordinates()
    {
        $query = "
          SELECT p.name,
            (SELECT a.value
              FROM attributes a
              WHERE a.deleted = 0
                AND a.idPlace = p.id
                AND a.name = 'Latitudine'
              LIMIT 1
            ) AS latitudine,
            (SELECT a.value
              FROM attributes a
              WHERE a.deleted = 0
                AND a.idPlace = p.id
                AND a.name = 'Longitudine'
              LIMIT 1
            ) AS longitudine,
            (SELECT t.name
              FROM tags t
              INNER JOIN places_tags pt ON pt.idTag = t.id
              WHERE t.deleted = 0
                AND pt.deleted = 0
                AND pt.idPlace = p.id
              LIMIT 1
            ) AS tag
          FROM $this->_table p
          WHERE p.deleted = 0
        ";
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function image()
    {
        $query = (new Query)
            ->select("image")
            ->from($this->_table)
            ->where("id = $this->_id");
        $ret = $this->query($query);
        if (!$ret || !($place = $ret->fetch_assoc())) {
            return null;
        }
        return $place["image"];
    }
}
