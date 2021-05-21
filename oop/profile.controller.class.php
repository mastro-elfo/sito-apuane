<?php

require_once "controller.class.php";
require_once "user.class.php";

class ProfileController extends Controller
{
    public function update($args)
    {
        $name  = $args["name"];
        $email = $args["email"];
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
                return $this->error(HTTP_NOT_FOUND);
            }
            // Reload user
            $user = $cUser->read();
            // Update session variable
            if ($user) {
                $_SESSION["user"] = $user;
            }
            $this->json(["ok" => true]);
        } else {
            $this->error(HTTP_UNAUTHORIZED);
        }
    }

    public function delete($args)
    {
        $password = $args["password"];
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
                $this->json(["ok" => true]);
            } else {
                $this->error(HTTP_BAD_REQUEST);
            }
        } else {
            $this->error(HTTP_UNAUTHORIZED);

        }
    }
}
