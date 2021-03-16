<?php
require_once "php/database.php";

class Place
{
    protected $_id          = null;
    protected $_name        = null;
    protected $_article     = null;
    protected $_title       = null;
    protected $_description = null;
    protected $_image       = null;
    protected $_uDateTime   = null;
    //
    protected $_db = null;

    public function __construct($id = null, $name = null, $article = null, $title = null, $description = null, $image = null)
    {
        $this->_id          = $id;
        $this->_name        = $name;
        $this->_article     = $article;
        $this->_title       = $title;
        $this->_description = $description;
        $this->_image       = $image;
        //
        $this->_db = open_db();
    }

    public function __get($key)
    {
        $_key = "_$key";
        return $this->$_key;
    }

    public function __set($key, $value)
    {
        if (in_array($key, ["name", "article", "title", "description", "image"])) {
            $_key        = "_$key";
            $this->$_key = $value;
        }
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
}
