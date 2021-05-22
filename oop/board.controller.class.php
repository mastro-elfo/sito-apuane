<?php

require_once "controller.class.php";
require_once "../oop/answer.class.php";
require_once "../oop/board.class.php";

class BoardController extends Controller
{

    public function create($args)
    {
        $title   = $args["title"];
        $content = $args["content"];
        if (isset($_SESSION["user"])) {
            $cBoard = new Board();
            $ret    = $cBoard->create([
                "title"   => $title,
                "content" => $content,
                "idUser"  => $_SESSION["user"]["id"],
            ]);
            if ($ret) {
                $this->json([
                    "ok"    => true,
                    "id" => $ret,
                ]);
            } else {
                $this->error(HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $this->error(HTTP_UNAUTHORIZED);
        }
    }

    public function answer($args)
    {
        $boardId = $args["boardId"];
        $content = $args["content"];
        if (isset($_SESSION["user"])) {
            $cAnswer = new Answer();
            $ret     = $cAnswer->create([
                "content" => $content,
                "idBoard" => $boardId,
                "idUser"  => $_SESSION["user"]["id"],
            ]);
            if ($ret) {
                $this->json(["ok" => !!$ret]);
            } else {
                $this->error(HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $this->error(HTTP_UNAUTHORIZED);
        }
    }

    public function deleteBoard($args)
    {
        $boardId = $args["boardId"];
        if (isset($_SESSION["user"])) {
            $ret = (new Board($boardId))
                ->delete(false, [
                    "idUser = " . $_SESSION["user"]["id"],
                ]);
            $this->json(["ok" => !!$ret]);
        } else {
            $this->error(HTTP_UNAUTHORIZED);
        }
    }

    public function deleteAnswer($args)
    {
        $answerId = $args["answerId"];
        if (isset($_SESSION["user"])) {
            $ret = (new Answer($answerId))
                ->delete(false, [
                    "idUser = " . $_SESSION["user"]["id"],
                ]);
            $this->json(["ok" => !!$ret]);
        } else {
            $this->error(HTTP_UNAUTHORIZED);
        }
    }

    public function editBoard($args)
    {
        $boardId = $args['boardId'];
        $title   = $args["title"];
        $content = $args["content"];
        if (isset($_SESSION["user"])) {
            $affected = (new Board($boardId))
                ->update([
                    "title"   => $title,
                    "content" => $content,
                ]);
            if ($affected) {
                $this->json(["ok" => !!$ret, "boardId" => $boardId]);
            } else {
                $this->error(HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $this->error(HTTP_UNAUTHORIZED);
        }
    }

    public function editAnswer($args)
    {
        $answerId = $args["answerId"];
        $content  = $args["content"];
        if (isset($_SESSION["user"])) {
            $ret = (new Answer($answerId))
                ->update([
                    "content" => $content,
                ]);
            $this->json(["ok" => !!$ret]);
        } else {
            $this->error(HTTP_UNAUTHORIZED);
        }
    }
}
