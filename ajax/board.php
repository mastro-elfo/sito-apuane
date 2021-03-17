<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "../php/board.class.php";

function create($title, $content)
{
    if (isset($_SESSION["user"])) {
        $board = new Board(null, $content, $_SESSION["user"], $title);
        return $board->create();
    }
    return null;
}

if ($_POST["action"] == "create") {
    echo json_encode(create($_POST["title"], $_POST["content"]));
} else {
    echo json_encode(null);
}
