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
    
    public function toBoard($idBoard)
    {
        $query = "
          SELECT
            a.id, a.idUser, a.content, a.uDateTime, u.name
          FROM answers a
          INNER JOIN users u ON u.id = a.idUser
          WHERE a.deleted = 0
            AND a.idBoard = $idBoard
            AND u.deleted = 0
          ORDER BY a.uDateTime DESC
        ";
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}