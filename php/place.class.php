<?php
require_once __DIR__ . "/model.class.php";

class Place extends Model
{
    protected $_id          = null;
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
        parent::__construct();
        $this->_id          = $id;
        $this->_name        = $name;
        $this->_article     = $article;
        $this->_title       = $title;
        $this->_description = $description;
        $this->_image       = $image;
    }

    public function create()
    {

    }

    public function read()
    {
        if ($this->_db) {
            $ret = $this->_db->query("
              SELECT p.name, p.article, p.title, p.description, p.image, p.uDateTime
              FROM places p
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
        }
        return false;
    }

    public function update()
    {
        if ($this->_db) {
            $ret = $this->_db->query("
            UPDATE places
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
        return false;
    }

    public function delete()
    {
        if ($this->_db) {
            $ret = $this->_db->query("
              UPDATE places
              SET deleted = 1
              WHERE id = '$this->_id'
            ");
            return $ret;
        }
        return false;
    }

    public function readRelated()
    {
        if ($this->_db) {
            $ret = $this->_db->query("
              SELECT
                o.id, o.name
              FROM places o
              INNER JOIN places_places pp ON pp.idTo = o.id
              WHERE pp.idFrom = '$this->_id'
                AND pp.deleted = 0
                AND o.deleted = 0
            ");
            if ($ret) {
                $this->_related = $ret->fetch_all(MYSQLI_ASSOC);
                return true;
            }
        }
        return false;
    }

    public function readTags()
    {
        if ($this->_db) {
            $ret = $this->_db->query("
              SELECT
                t.id, t.name, t.color, t.textColor
              FROM tags t
              INNER JOIN places_tags pt ON pt.idTag = t.id
              WHERE
                    pt.idPlace = '$this->_id'
                AND t.deleted = 0
                AND pt.deleted = 0
            ");
            if ($ret) {
                $this->_tags = $ret->fetch_all(MYSQLI_ASSOC);
                return true;
            }
        }
        return false;
    }

    public function readAttributes()
    {
        if ($this->_db) {
            $ret = $this->_db->query("
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
        }
        return false;
    }
}
