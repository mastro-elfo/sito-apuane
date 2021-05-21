<?php
require_once "controller.class.php";
require_once "user.class.php";

class LoginController extends Controller
{
    public function login($args)
    {
        $username = $args["username"];
        $password = $args["password"];
        $user     = (new User)->login($username, $password);
        $this->json(["response" => !!$user]);
    }

    public function logout()
    {
        $ret = (new User)->logout();
        $this->json(["response" => !!$ret]);
    }
}
