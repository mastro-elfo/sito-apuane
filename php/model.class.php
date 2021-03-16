<?php

require_once __DIR__."/database.php";

class Model {
  //
    protected $_db = null;

    public function __construct()
    {
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

    public function create(){
      return false;
    }

    public function read(){
      return null;
    }

    public function update(){
      return false;
    }

    public function delete(){
      return false;
    }
}
 ?>
