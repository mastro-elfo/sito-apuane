<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!array_key_exists("user", $_SESSION)) {
    header("Location: login.php?error=" . urlencode("Devi eseguire l'accesso"));
    exit;
}

if (!array_key_exists("boardId", $_GET)) {
    header("Location: bacheca.php?error=" . urlencode("Messaggio non definito"));
    exit;
}

$boardId  = $_GET["boardId"];
$answerId = array_key_exists("answerId", $_GET) ? $_GET["answerId"] : null;

require_once "lib/php/parsedown-master/Parsedown.php";
require_once "oop/answer.class.php";
require_once "oop/board.class.php";
require_once "php/i18n.php";

//
$cBoard = new Board($boardId);
$board  = $cBoard->read();
$i18n = i18n("board");

if (!$board) {
    header("Location: bacheca.php?error=" . urlencode("Messaggio non trovato: $boardId"));
    exit;
}

$answer = null;
if ($answerId) {
    $answer = (new Answer($answerId))->read();
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
    <title><?=$i18n["answer_title"]?></title>
    <script src="lib/js/jquery-3.6.0.js"></script>
    <script src="lib/js/SnackBar-master/dist/snackbar.min.js"></script>
    <script src="js/snackbar.js"></script>
    <script src="js/bacheca.js"></script>
  </head>
  <body>
    <?php require "php/nav.php";?>
    <!-- Main content -->
    <main>
      <form>
        <fieldset>
          <label><?=$i18n["answer_to"]?> <?=$board["user_name"]?></label>
          <p class="mb1"><?=$board["title"]?></p>
          <label for="content"><?=$i18n["text"]?></label>
          <textarea
            id="content"
            rows="8" cols="40"
            placeholder="<?=$i18n["message"]?>"
            class="mb1"
            ><?=$answer && array_key_exists("content", $answer) ? $answer["content"] : ""?></textarea>
          <div class="button-container">
            <button
              type="button"
              id="answer"
              class="bSuccess"
              ><?=$i18n["answer"]?></button>
            <a
              href="bacheca.php?id=<?=$board["id"]?>"
              class="button bWarning"
              ><?=$i18n["cancel"]?></a>
          </div>
          <input type="hidden" id="boardId" value="<?=$boardId?>">
          <input type="hidden" id="answerId" value="<?=$answerId?>">
        </fieldset>
      </form>
    </main>
    <!-- Footer -->
    <footer class="py1"></footer>
  </body>
</html>
