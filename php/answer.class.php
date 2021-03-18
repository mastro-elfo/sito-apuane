<?php

require_once __DIR__ . "/model.class.php";

class Answer extends Model
{
    protected $_table = "answers";
    // Properties
    protected $_content = null;
    protected $_answer  = null;
    protected $_board   = null;
    protected $_user    = null;

    public function __construct($id = null, $content = null, $answer = null, $board = null, $user = null)
    {
        parent::__construct($id);
        $this->_content = $content;
        $this->_answer  = $answer;
        $this->_board   = $board;
        $this->_user    = $user;
    }

    public function create()
    {
        $idAnswer = $this->_answer["id"] ? "'" . $this->_answer["id"] . "'" : "NULL";
        $idBoard  = $this->_board["id"] ? "'" . $this->_board["id"] . "'" : null;
        $ret      = $this->query("
          INSERT INTO `$this->_table`
            (content, idUser, idBoard, idAnswer)
          VALUES
            ('$this->_content', '" . $this->_user["id"] . "', $idBoard, $idAnswer)
        ");
        if ($ret) {
            return $this->_db->insert_id;
        }
        return false;
    }

    public function delete($idUser = null)
    {
        if ($this->_db) {
            $ret = $this->_db->query("
              UPDATE `$this->_table`
              SET deleted = 1
              WHERE id = '$this->_id'
                AND idUser = '$idUser'
            ");
            return $ret;
        }
        return false;
    }
}
