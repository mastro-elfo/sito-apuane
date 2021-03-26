<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "../oop/answer.class.php";
require_once "../oop/board.class.php";

function create($title, $content)
{
    if (isset($_SESSION["user"])) {
        $cBoard = new Board();
        $ret    = $cBoard->create([
            "title"   => $title,
            "content" => $content,
            "idUser"  => $_SESSION["user"]["id"],
        ]);
        if ($ret) {
            return $ret;
        }
    }
    http_response_code(400);
    return null;
}

function answer($boardId, $content)
{
    if (isset($_SESSION["user"])) {
        $cAnswer = new Answer();
        $ret     = $cAnswer->create([
            "content" => $content,
            "idBoard" => $boardId,
            "idUser"  => $_SESSION["user"]["id"],
        ]);
        if ($ret) {
            return $ret;
        }
    }
    return null;
}

function deleteBoard($boardId)
{
    if (isset($_SESSION["user"])) {
        $board = new Board($boardId);
        return $board->delete($_SESSION["user"]["id"]);
    }
    return null;
}

function deleteAnswer($answerId)
{
    if (isset($_SESSION["user"])) {
        $answer = new Answer($answerId);
        return $answer->delete($_SESSION["user"]["id"]);
    }
    return null;
}

function editBoard($boardId, $title, $content)
{
    if (isset($_SESSION["user"])) {
        (new Board($boardId))
            ->update([
                "title"   => $title,
                "content" => $content,
            ]);
        return $boardId;
    }
    return null;
}

if ($_POST["action"] == "create") {
    echo json_encode(create($_POST["title"], $_POST["content"]));
} elseif ($_POST["action"] == "answer") {
    echo json_encode(answer($_POST["boardId"], $_POST["content"]));
} elseif ($_POST["action"] == "delete-board") {
    echo json_encode(deleteBoard($_POST["boardId"]));
} elseif ($_POST["action"] == "delete-answer") {
    echo json_encode(deleteAnswer($_POST["answerId"]));
} elseif ($_POST["action"] == "edit-board") {
    echo json_encode(editBoard($_POST["boardId"], $_POST["title"], $_POST["content"]));
} else {
    http_response_code(400);
    echo json_encode(null);
}
