<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!array_key_exists("user", $_SESSION)) {
    header("Location: login.php");
    exit;
}

require_once "lib/php/parsedown-master/Parsedown.php";
require_once "oop/board.class.php";
require_once "php/i18n.php";

$i18n = i18n("board");
$boardId = array_key_exists("id", $_GET) ? $_GET["id"] : null;
$cBoard  = new Board($boardId);
$board   = [
    "title"   => "",
    "content" => "",
];
if ($boardId) {
    $ret = $cBoard->read();
    if ($ret) {
        $board = $ret;
    }
}
?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="lib/js/SnackBar-master/dist/snackbar.min.css">
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title><?=$i18n["write_title"]?></title>
    <script src="lib/js/jquery-3.6.0.js"></script>
    <script src="lib/js/SnackBar-master/dist/snackbar.min.js"></script>
    <script src="js/snackbar.js" charset="utf-8"></script>
    <script src="js/bacheca.js"></script>
  </head>
  <body>
    <?php require "php/nav.php";?>
    <!-- Main content -->
    <main>
      <form>
        <fieldset>
          <label for="title"><?=$i18n["message_title"]?></label>
          <input
            id="title"
            type="text"
            value="<?=$board["title"]?>"
            placeholder=""
            autofocus/>
          <label for="content"><?=$i18n["text"]?></label>
          <textarea
            id="content"
            rows="8" cols="40"
            placeholder="<?=$i18n["message"]?>"
            ><?=$board["content"]?></textarea>
          <div class="button-container mt1">
            <button
              type="button"
              id="write"
              class="bSuccess"><?=$i18n["confirm"]?></button>
            <a
              id="cancel"
              class="button bWarning"
              href="bacheca.php"
              ><?=$i18n["cancel"]?></a>
          </div>
          <input type="hidden" id="boardId" value="<?=$boardId?>">
        </fieldset>
      </form>
    </main>
    <!-- Footer -->
    <footer class="py1"></footer>
  </body>
</html>
