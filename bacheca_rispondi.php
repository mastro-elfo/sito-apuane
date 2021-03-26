<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!array_key_exists("user", $_SESSION)) {
    header("Location: login.php?error=" . urlencode("Devi eseguire l'accesso"));
    exit;
}

if (!array_key_exists("id", $_GET)) {
    header("Location: bacheca.php?error=" . urlencode("Messaggio non definito"));
    exit;
}

$boardId = $_GET["id"];

require_once "lib/php/parsedown-master/Parsedown.php";
require_once "oop/board.class.php";
//
$cBoard = new Board($boardId);
$board  = $cBoard->read();

if (!$board) {
    header("Location: bacheca.php?error=" . urlencode("Messaggio non trovato: $boardId"));
    exit;
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
    <title>Rispondi a messaggio</title>
    <script src="lib/js/jquery-3.6.0.js"></script>
    <script src="lib/js/SnackBar-master/dist/snackbar.min.js" charset="utf-8"></script>
    <script src="js/snackbar.js" charset="utf-8"></script>
    <script src="js/bacheca.js"></script>
  </head>
  <body>
    <?php require "php/nav.php";?>
    <form>
      <fieldset>
        <label>Risposta a </label>
        <p><?=$board["title"]?>, <?=$board["user_name"]?></p>
        <label for="content">Testo</label>
        <textarea id="content" rows="8" cols="40" placeholder="Messaggio"></textarea>
        <div class="button-container mt1">
          <button type="button" id="answer">Rispondi</button>
          <button
            type="button"
            id="cancel"
            class="bWarning"
            onclick="location.href = 'bacheca.php?id=<?=$board["id"]?>'"
            >Annulla</button>
        </div>
      </fieldset>
    </form>
  </body>
</html>
