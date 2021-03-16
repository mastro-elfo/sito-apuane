<?php

require_once __DIR__ . "/model.class.php";

class Board extends Model
{
    protected $_table = "boards";
    // Properties
    protected $_content   = null;
    protected $_user      = null;
    protected $_title     = null;
    protected $_uDateTime = null;

    public function __construct($id = null, $content = null, $user = null, $title = null)
    {
        parent::__construct($id);
        $this->_content = $content;
        $this->_user    = $user;
        $this->_title   = $title;
    }

    public function create()
    {
        return false;
    }

    public function read()
    {
        $ret = $this->query("
          SELECT
            b.content, b.title, b.uDateTime,
            u.name as user_name
          FROM `$this->_table` b
          INNER JOIN users u ON u.id = b.idUser
          WHERE b.deleted = 0
            AND u.deleted = 0
        ");
        if ($ret) {
            $board          = $ret->fetch_assoc();
            $this->_content = $board["content"];
            $this->_user    = [
                "name" => $board["user_name"],
            ];
            $this->_title = $board["title"];
            return true;
        }
        return false;
    }

    public function readAll(){
      $ret = $this->query("
        SELECT
          b.id, b.title, b.content, b.uDateTime,
          u.name as user_name
        FROM `$this->_table` b
        INNER JOIN users u ON u.id = b.idUser
        WHERE b.deleted = 0
        ORDER BY b.uDateTime DESC
      ");
      if($ret){
        return $ret->fetch_all(MYSQLI_ASSOC);
      }
      return [];
    }


    public function readAnswers(){
      $ret = $this->query("
        SELECT
          a.content, a.uDateTime, u.name
        FROM answers a
        INNER JOIN users u ON u.id = a.idUser
        WHERE a.deleted = 0
          AND a.idBoard = '$this->_id'
          AND u.deleted = 0
        ORDER BY a.uDateTime DESC
      ");
      if($ret) {
        return $ret->fetch_all(MYSQLI_ASSOC);
      }
      return [];
    }
}
