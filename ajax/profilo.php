<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "../php/user.class.php";

function update($name, $email)
{
    // Get user id from session
    $userId = $_SESSION["user"]["id"];
    // Create new User
    $user = new User($_SESSION["user"]["id"], $email, $name);
    // Update user
    $ret = $user->update();
    if(!$ret) {
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

if ($_POST["action"] == "update") {
    echo json_encode(update($_POST["name"], $_POST["email"]));
}
