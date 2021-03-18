<?php

require_once __DIR__ . "/database.php";

class Model
{
    // mysqli database object
    protected $_db = null;
    // table name
    protected $_table = null;
    // row id
    protected $_id = null;

    public function __construct($id = null)
    {
        $this->_id = $id;
        $this->_db = open_db();
    }

    public function __get($key)
    {
        $_key = "_$key";
        if (property_exists($this, $_key)) {
            return $this->$_key;
        }
        return null;
    }

    // public function __set($key, $value)
    // {
    //     // TODO: E' specifico per places
    //     if (in_array($key, ["name", "article", "title", "description", "image"])) {
    //         $_key        = "_$key";
    //         $this->$_key = $value;
    //     }
    // }

    public function query($q)
    {
        if ($this->_db) {
            return $this->_db->query($q);
        }
        return false;
    }

    public function last()
    {
        $ret = $this->query("
          SELECT LAST_INSERT_ID() AS id
          FROM `$this->_table`
          LIMIT 1
        ");
        if ($ret) {
            return $ret->fetch_assoc();
        }
        return false;
    }

    public function create()
    {
        return false;
    }

    public function read()
    {
        return null;
    }

    public function update()
    {
        return false;
    }

    public function delete()
    {
        if ($this->_db) {
            $ret = $this->_db->query("
              UPDATE `$this->_table`
              SET deleted = 1
              WHERE id = '$this->_id'
            ");
            return $ret;
        }
        return false;
    }
}
