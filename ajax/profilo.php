<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "../oop/profile.controller.class.php";
(new ProfileController())->action($_POST["action"], $_POST);
