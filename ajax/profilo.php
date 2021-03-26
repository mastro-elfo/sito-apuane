<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "../oop/user.class.php";

function update($name, $email)
{
    if (isset($_SESSION["user"]["id"])) {
        // Get user id from session
        $userId = $_SESSION["user"]["id"];
        // Create new User
        $cUser = new User($userId);
        // Update user
        $ret = $cUser->update([
            "email" => $email,
            "name"  => $name,
        ]);
        // Check return
        if (!$ret) {
            http_response_code(404);
            return null;
        }
        // Reload user
        $user = $cUser->read();
        // Update session variable
        if ($user) {
            $_SESSION["user"] = $user;
        }
        return $user;
    }
    http_response_code(400);
    return false;
}

function delete($password)
{
    if (isset($_SESSION["user"]["id"])) {
        // Get user id from session
        $userId = $_SESSION["user"]["id"];
        $cUser  = new User($userId);
        $ret    = $cUser->delete(false, [
            "password = '" . hash("sha256", $password) . "'",
        ]);
        if ($ret) {
            unset($_SESSION["user"]);
            session_destroy();
            return $ret;
        }
    }
    http_response_code(400);
    return false;
}

if ($_POST["action"] == "update") {
    echo json_encode(update($_POST["name"], $_POST["email"]));
} elseif ($_POST["action"] == "delete") {
    echo json_encode(delete($_POST["password"]));
} else {
    http_response_code(400);
    echo json_encode(null);
}
