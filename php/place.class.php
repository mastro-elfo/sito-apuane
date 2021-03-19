<?php
require_once __DIR__ . "/model.class.php";

class Place extends Model
{
    // Set table name
    protected $_table = "places";
    // Set properties
    protected $_name        = null;
    protected $_article     = null;
    protected $_title       = null;
    protected $_description = null;
    protected $_image       = null;
    protected $_uDateTime   = null;
    protected $_related     = [];
    protected $_tags        = [];
    protected $_attributes  = [];

    public function __construct($id = null, $name = null, $article = null, $title = null, $description = null, $image = null)
    {
        parent::__construct($id);
        $this->_name        = $name;
        $this->_article     = $article;
        $this->_title       = $title;
        $this->_description = $description;
        $this->_image       = $image;
    }

    // public function create()
    // {
    //
    // }

    public function read()
    {
        $ret = $this->query("
          SELECT p.name, p.article, p.title, p.description, !isnull(p.image) as image, p.uDateTime
          FROM `$this->_table` p
          WHERE p.id = '$this->_id'
            AND p.deleted = 0
        ");
        if ($ret) {
            $place              = $ret->fetch_assoc();
            $this->_name        = $place["name"];
            $this->_article     = $place["article"];
            $this->_title       = $place["title"];
            $this->_description = $place["description"];
            $this->_image       = $place["image"];
            $this->_uDateTime   = $place["uDateTime"];
            return true;
        }
        return false;
    }

    public function update()
    {
        $ret = $this->query("
          UPDATE `$this->_table`
          SET
            name = '$this->_name',
            article = '$this->_article',
            title = '$this->_title',
            description = '$this->_description',
            image = '$this->_image'
          WHERE id = '$this->_id'
        ");
        return $ret;
    }

    public function readRelated()
    {
        $ret = $this->query("
          SELECT
            o.id, o.name
          FROM places o
          INNER JOIN places_places pp ON pp.idTo = o.id
          WHERE pp.idFrom = '$this->_id'
            AND pp.deleted = 0
            AND o.deleted = 0
          ORDER BY o.name ASC
        ");
        if ($ret) {
            $this->_related = $ret->fetch_all(MYSQLI_ASSOC);
            return true;
        }
        return false;
    }

    public function readTags()
    {
        $ret = $this->query("
          SELECT
            t.id, t.name, t.color, t.textColor
          FROM tags t
          INNER JOIN places_tags pt ON pt.idTag = t.id
          WHERE
                pt.idPlace = '$this->_id'
            AND t.deleted = 0
            AND pt.deleted = 0
          ORDER BY t.name ASC
        ");
        if ($ret) {
            $this->_tags = $ret->fetch_all(MYSQLI_ASSOC);
            return true;
        }
        return false;
    }

    public function readAttributes()
    {
        $ret = $this->query("
          SELECT
            a.name, a.value, a.after
          FROM attributes a
          WHERE
                a.idPlace = '$this->_id'
            AND a.deleted = 0
        ");
        if ($ret) {
            $this->_attributes = $ret->fetch_all(MYSQLI_ASSOC);
            return true;
        }
        return false;
    }

    public function readAll()
    {
        $ret = $this->query("
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
        ORDER BY p.name ASC
      ");
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function readCoordinates()
    {
        $ret = $this->query("
          SELECT p.name,
            (SELECT a.value
             FROM attributes a
             WHERE a.deleted = 0
               AND a.idPlace = p.id
               AND a.name = 'Latitudine'
            ) AS latitudine,
            (SELECT a.value
             FROM attributes a
             WHERE a.deleted = 0
               AND a.idPlace = p.id
               AND a.name = 'Longitudine'
            ) AS longitudine,
            (SELECT t.name
              FROM tags t
              INNER JOIN places_tags pt ON pt.idTag = t.id
              WHERE t.deleted = 0
                AND pt.deleted = 0
                AND pt.idPlace = p.id
              LIMIT 1
            ) AS tag
          FROM places p
          WHERE p.deleted = 0
        ");
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function readLatest($offset = 0, $count = 10) {
        $ret = $this->query("
          SELECT p.id,
            p.name,
            p.description,
            p.title,
            !isnull(p.image) as image,
            p.uDateTime
          FROM `$this->_table` p
          WHERE p.deleted = 0
          ORDER BY p.uDateTime DESC
          LIMIT $offset, $count
        ");
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
