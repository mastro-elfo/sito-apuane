<?php
require_once __DIR__ . "/model.class.php";

class User extends Model
{
    // Set table name
    protected $_table = "users";
    // Set properties
    protected $_email     = null;
    protected $_name      = null;
    protected $_uDateTime = null;
    protected $_admin     = false;

    public function __construct($id = null, $email = null, $name = null)
    {
        parent::__construct($id);
        $this->_email = $email;
        $this->_name  = $name;
    }

    public function read()
    {
        $ret = $this->query("
        SELECT u.id, u.email, u.name, u.uDateTime, u.admin
        FROM `$this->_table` u
        WHERE u.id = '$this->_id'
          AND u.deleted = 0
      ");
        if ($ret) {
            $user             = $ret->fetch_assoc();
            $this->_email     = $user["email"];
            $this->_name      = $user["name"];
            $this->_admin     = $user["admin"];
            $this->_uDateTime = $user["uDateTime"];
            return $user;
        }
        return false;
    }

    public function update()
    {
        $ret = $this->query("
          UPDATE `$this->_table`
          SET
            email = '$this->_email',
            name = '$this->_name'
          WHERE
            id = '$this->_id'
        ");
        return $ret;
    }

    public function login($username, $password)
    {
        $ret = $this->query("
          SELECT id, name, email, admin
          FROM `$this->_table`
          WHERE deleted = 0
            AND email = '$username'
            AND password = '" . hash("sha256", $password) . "'
      ");
        if ($ret) {
            return $ret->fetch_assoc();
        }
        return null;
    }
}
