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
        // Check valid fields
        if (!array_key_exists("email", $columns)
            || !array_key_exists("password", $columns)
            || trim($columns["email"]) == ""
            || trim($columns["password"]) == "") {
            return null;
        }
        // Check email not used;
        $user = $this->query(
            (new Query)
                ->select()
                ->from($this->_table)
                ->where("email = '$columns[email]'")
                ->and("deleted = 0")
        );
        if ($user && $user->fetch_assoc()) {
            return null;
        }
        // Encrypt password
        $columns["password"] = hash("sha256", $columns["password"]);
        // Create row
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
