<?php

require_once "controller.class.php";
require_once "user.class.php";

class SignupController extends Controller
{

    public function signup($args)
    {
        $name     = $args["name"];
        $email    = $args["email"];
        $password = $args["password"];
        $cUser    = new User();
        $id       = $cUser->create([
            "name"     => $name,
            "email"    => $email,
            "password" => $password,
        ]);
        if ($id) {
            $this->json(["id" => $id]);
        } else {
            $this->json(["id" => $id], HTTP_BAD_REQUEST);
        }
    }
}
