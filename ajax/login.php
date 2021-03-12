<?php
session_start();

require_once "database.php";

function login($username, $password)
{
    // Open db connection
    $db = open_db();
    // On error return null
    if (!$db) {
        return null;
    }
    $ret = $db->query("
      SELECT id, nome, email FROM utenti
      WHERE
            email = '$username'
        AND password = '" . hash("sha256", $password) . "'
    ");
    $user = $ret->fetch_assoc();
    if ($user) {
        $_SESSION["user"] = $user;
    }
    return $user;
}

function logout()
{
    if (isset($_SESSION["user"])) {
        unset($_SESSION["user"]);
        return "Logout";
    }
    return "Error";
}

if ($_POST["action"] == "login") {
    echo json_encode(login($_POST["username"], $_POST["password"]));
} elseif ($_POST["action"] == "logout") {
    echo json_encode(logout());
}
