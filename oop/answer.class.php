<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/model.class.php";
require_once __DIR__ . "/query.class.php";

class Answer extends Model
{
    public function __construct($id = null)
    {
        parent::__construct("answers", $id);
    }

    public function toBoard($idBoard)
    {
        $query = (new Query)
            ->select(["a.id", "a.idUser", "a.content", "a.uDateTime", "u.name"])
            ->from("answers a")
            ->join("users u", "u.id = a.idUser")
            ->where("a.deleted = 0")
            ->and("a.idBoard = $idBoard")
            ->and("u.deleted = 0")
            ->order(["a.uDateTime" => "DESC"]);
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
