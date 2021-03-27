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
        // Query tags
        $query_t = (string) (new Query)
            ->select("GROUP_CONCAT(t.name, '/', t.color, '/', t.textColor SEPARATOR ',')")
            ->from("tags t")
            ->join("places_tags pt", "pt.idTag = t.id")
            ->where("pt.idPlace = p.id");
        // Query
        $query = (new Query)
            ->select(["p.id", "p.name", "p.title", "($query_t) AS tags"])
            ->from("$this->_table p")
            ->where("p.deleted = 0")
            ->order("p.name ASC");
        // Filter by name
        if ($string) {
            $query->and("p.name LIKE '%$string%'");
        }
        if ($tag) {
            $query
                ->join("places_tags pt", "pt.idPlace = p.id")
                ->join("tags t", "t.id = pt.idTag")
                ->and("t.name = '$tag'");
        }
        // Filter by tag
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }

    public function related()
    {
        $query = (new Query)
            ->select(["o.id", "o.name"])
            ->from("places o")
            ->join("places_places pp", "pp.idTo = o.id")
            ->where("pp.idFrom = $this->_id")
            ->and("pp.deleted = 0")
            ->and("o.deleted = 0")
            ->order("o.name ASC");
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
            ->order("uDateTime DESC")
            ->limit($offset, $count);
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function coordinates()
    {
        $query_lat = (string) (new Query)
            ->select("a.value")
            ->from("attributes a")
            ->where("a.deleted = 0")
            ->and("a.idPlace = p.id")
            ->and("a.name = 'Latitudine'")
            ->limit(1);
        $query_lon = (string) (new Query)
            ->select("a.value")
            ->from("attributes a")
            ->where("a.deleted = 0")
            ->and("a.idPlace = p.id")
            ->and("a.name = 'Longitudine'")
            ->limit(1);
        $query_tag = (string) (new Query)
            ->select("t.name")
            ->from("tags t")
            ->join("places_tags pt", "pt.idTag = t.id")
            ->where("t.deleted = 0")
            ->and("pt.deleted = 0")
            ->and("pt.idPlace = p.id")
            ->order("pt.main DESC")
            ->limit(1);
        $query = (new Query)
            ->select([
                "p.name",
                "($query_lat) AS latitudine",
                "($query_lon) AS longitudine",
                "($query_tag) as tag",
            ])
            ->from("$this->_table p")
            ->where("p.deleted = 0");
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
