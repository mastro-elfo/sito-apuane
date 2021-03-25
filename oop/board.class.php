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

    public function read($columns = null)
    {
        if ($columns) {
            return parent::read($columns);
        }
        $ret = $this->query("
          SELECT
            b.id, b.content, b.title, b.uDateTime,
            u.id as user_id, u.name as user_name
          FROM `$this->_table` b
          INNER JOIN users u ON u.id = b.idUser
          WHERE b.id = '$this->_id'
            AND b.deleted = 0
            AND u.deleted = 0
        ");
        if (!$ret) {
            return null;
        }
        return $ret->fetch_assoc();
    }

    public function delete($userId = null, $force = false)
    {
        $query = (new Query);
        if ($force) {
            // Delete row from table
            $query
                ->delete()
                ->from($this->_table);
        } else {
            // Soft delete
            $query->update($this->_table)
                ->set(["deleted" => 1]);
        }
        $query->where("id = $this->_id")
            ->and("idUser = $userId");
        $ret = $this->query($query);
        if ($ret) {
            return $this->_db->get_affected();
        }
        return null;
    }

    public function search($string = null, $userId = null)
    {
        $query = "
          SELECT
            b.id, b.title, b.content, b.uDateTime,
            u.name as user_name,
            (SELECT COUNT(*)
              FROM answers a
              WHERE a.idBoard = b.id
                AND a.deleted = 0
            ) AS answers
          FROM `$this->_table` b
          INNER JOIN users u ON u.id = b.idUser
          WHERE b.deleted = 0
          " . ($string ? "AND b.title LIKE '%$string%'" : "") . "
          ".($userId ? "AND u.id = $userId" : "")."
          ORDER BY b.uDateTime DESC
        ";
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
}
