<?php
session_start();

require_once "../oop/user.class.php";

function login($username, $password) {
  return (new User)->login($username, $password);
}

function logout()
{
    return (new User)->logout();
}

if ($_POST["action"] == "login") {
    echo json_encode(login($_POST["username"], $_POST["password"]));
} elseif ($_POST["action"] == "logout") {
    echo json_encode(logout());
}
