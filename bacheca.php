<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "lib/php/parsedown-master/Parsedown.php";
require_once "php/board.class.php";

$pd = new Parsedown();

// Inizializzo variabili di pagina
$error       = null;
$title       = "Bacheca";
$description = "Bacheca del sito";
$h1          = "";
$article     = "";
$author      = "";
$datetime    = "";
$showBoard   = false;
$boards      = [];
//
$boardId = array_key_exists("id", $_GET) ? $_GET["id"] : null;
//
$board = new Board($boardId);

if ($boardId) {
    if ($board->read()) {
        $title       = $board->title;
        $description = $board->content;
        $h1          = $board->title;
        $article     = $board->content;
        $author      = $board->user["name"];
        $datetime    = $board->uDateTime;
        $showBoard   = true;
    }
} else {
    // Carico la lista dei messaggi
    $boards = $board->readAll();
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
    <link rel="stylesheet" href="css/bacheca.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title><?=$title?></title>
  </head>
  <body>
    <?php require "php/nav.php";?>

    <main>
      <?php if ($error): ?>
        <p class="error p1"><?=$error?></p>
      <?php endif;?>

      <?php if ($showBoard): ?>
        <article>
          <h2><?=$h1?></h2>
          <?=$pd->text($article)?>
          <footer>
            <p>
              <?=$author?>,
              <time datetime="<?=$datetime?>">
                <?=date_format(date_create($datetime), "d/m/Y")?>
              </time>
            </p>
          </footer>
        </article>
      <?php elseif (count($boards)): ?>
        <div id="boards">
          <?php foreach ($boards as $board): ?>
            <a href="bacheca.php?id=<?=$board["id"]?>">
              <section>
                <header>
                  <h3><?=$board["title"]?></h3>
                </header>
                <?=$pd->text(strlen($board["content"]) > 100 ? substr($board["content"], 0, 100) . "&hellip;" : $board["content"])?>
                <footer>
                  <p>
                    <?=$board["user_name"]?>,
                    <time datetime="<?=$datetime?>">
                      <?=date_format(date_create($datetime), "d/m/Y")?>
                    </time>
                  </p>
                </footer>
              </section>
            </a>
          <?php endforeach;?>
        </div>
      <?php endif;?>
    </main>
  </body>
</html>
