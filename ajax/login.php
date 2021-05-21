<?php
session_start();
require_once "../oop/login.controller.class.php";
(new LoginController())->action($_POST["action"], $_POST);
