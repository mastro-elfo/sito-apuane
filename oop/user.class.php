<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/model.class.php";
require_once __DIR__ . "/query.class.php";

class User extends Model
{
    public function __construct($id = null)
    {
        parent::__construct("users", $id);
    }

    public function login($username, $password)
    {
        $query = (new Query)
            ->select(["id", "name", "email"])
            ->from($this->_table)
            ->where("email = '$username'")
            ->and("password = '" . hash("sha256", $password) . "'");
        $ret = $this->query($query);
        if ($ret) {
            $assoc = $ret->fetch_assoc();
            if (isset($_SESSION)) {
                $_SESSION["user"] = $assoc;
            }
            return $assoc;
        }
        return null;
    }

    public function logout()
    {
        if (isset($_SESSION)) {
            $_SESSION = [];
        }
    }
}
