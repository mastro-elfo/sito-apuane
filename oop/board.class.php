<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/model.class.php";
require_once __DIR__ . "/query.class.php";

class Board extends Model
{
    public function __construct($id = null)
    {
        parent::__construct("boards", $id);
    }

    public function read($columns = null, $ands = [])
    {
        if ($columns) {
            return parent::read($columns);
        }
        $query = (new Query)
            ->select(["b.id", "b.content", "b.title", "b.uDateTime", "u.id as user_id", "u.name as user_name"])
            ->from("$this->_table b")
            ->join("users u", "u.id = b.idUser")
            ->where("b.id = $this->_id")
            ->and("b.deleted = 0")
            ->and("u.deleted = 0");
        $ret = $this->query($query);
        if (!$ret) {
            return null;
        }
        return $ret->fetch_assoc();
    }

    public function search($string = null, $userId = null)
    {
        // Query how many answers
        $query_a = (string) (new Query)
            ->select("COUNT(*)")
            ->from("answers a")
            ->where("a.idBoard = b.id")
            ->and("a.deleted = 0");
        // Main query
        $query = (new Query)
            ->select(["b.id", "b.title", "b.content", "b.uDateTime", "u.name as user_name", "($query_a) as answers"])
            ->from("$this->_table b")
            ->join("users u", "u.id = b.idUser")
            ->where("b.deleted = 0")
            ->order(["b.uDateTime" => "DESC"]);
        // Search by string
        if ($string) {
            $query->and("b.title LIKE '%$string%'");
        }
        // Filter by user id
        if ($userId) {
            $query->and("u.id = $userId");
        }
        // Query
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
}
