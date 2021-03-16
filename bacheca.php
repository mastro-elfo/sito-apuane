<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "lib/php/parsedown-master/Parsedown.php";
// require_once "php/board.class.php";

$pd = new Parsedown();

// Inizializzo variabili di pagina
$error       = "Pagina in costruzione"; // null
$title       = "Bacheca";
$description = "Bacheca del sito";

//
$boardId = array_key_exists("id", $_GET) ? $_GET["id"] : null;

if ($boardId) {

} else {
    // Carico la lista dei messaggi
}

?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="<?=$description?>"
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title><?=$title?></title>
  </head>
  <body>
    <?php require "php/nav.php";?>

    <main>
      <?php if ($error): ?>
        <p class="error p1"><?=$error?></p>
      <?php endif;?>
    </main>
  </body>
</html>
