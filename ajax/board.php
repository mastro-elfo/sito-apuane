<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "../php/answer.class.php";
require_once "../php/board.class.php";

function create($title, $content)
{
    if (isset($_SESSION["user"])) {
        $board = new Board(null, $content, $_SESSION["user"], $title);
        return $board->create();
    }
    return null;
}

function answer($boardId, $content)
{
    if (isset($_SESSION["user"])) {
        $answer = new Answer(
            null,
            $content,
            ["id" => null],
            ["id" => $boardId],
            $_SESSION["user"]
        );
        return $answer->create();
    }
    return null;
}

if ($_POST["action"] == "create") {
    echo json_encode(create($_POST["title"], $_POST["content"]));
} elseif ($_POST["action"] == "answer") {
    echo json_encode(answer($_POST["boardId"], $_POST["content"]));
} else {
    echo json_encode(null);
}
