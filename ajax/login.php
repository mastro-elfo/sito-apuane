<?php
session_start();

require_once "../php/user.class.php";

function login($username, $password) {
  $user = new User();
  $u = $user->login($username, $password);
  if($u) {
    $_SESSION["user"] = $u;
  }
  return $u;
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
