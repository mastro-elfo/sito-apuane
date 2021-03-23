<?php

require_once "../oop/user.class.php";

function signup($name, $email, $password)
{
    $cUser = new User();
    $id    = $cUser->create([
        "name"     => $name,
        "email"    => $email,
        "password" => $password,
    ]);
    return $id;
}

if ($_POST["action"] == "signup") {
    echo json_encode(signup(
      $_POST["name"], $_POST["email"], $_POST["password"]
    ));
} else {
    http_response_code(400);
}
