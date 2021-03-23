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

    public function create($columns)
    {
        if (!array_key_exists("email", $columns)
            || !array_key_exists("password", $columns)
            || trim($columns["email"]) == ""
            || trim($columns["password"]) == "") {
            return null;
        }
        $columns["password"] = hash("sha256", $columns["password"]);
        return parent::create($columns);
    }

    public function login($username, $password)
    {
        $query = (new Query)
            ->select(["id", "name", "email", "admin"])
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
