<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "../php/user.class.php";

function update($name, $email)
{
    if (isset($_SESSION["user"]["id"])) {
        // Get user id from session
        $userId = $_SESSION["user"]["id"];
        // Create new User
        $user = new User($userId, $email, $name);
        // Update user
        $ret = $user->update();
        if (!$ret) {
            return null;
        }
        // Reload user
        $u = $user->read();
        // Update session variable
        if ($u) {
            $_SESSION["user"] = $u;
        }
        return $u;
    }
    http_response_code(401);
    return false;
}

function delete()
{
    if (isset($_SESSION["user"]["id"])) {
        // Get user id from session
        $userId = $_SESSION["user"]["id"];
        $user   = new User($userId);
        return $user->delete();
    }
    http_response_code(401);
    return false;
}

if ($_POST["action"] == "update") {
    echo json_encode(update($_POST["name"], $_POST["email"]));
} elseif ($_POST["action"] == "delete") {
    echo json_encode(delete());
} else {
    echo json_encode(null);
}
