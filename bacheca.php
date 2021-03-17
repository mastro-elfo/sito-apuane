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
$answers     = [];
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
        $answers     = $board->readAnswers();
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
    <link rel="stylesheet" href="lib/jquery-ui-1.12.1.custom/jquery-ui.min.css">
    <link rel="stylesheet" href="lib/jquery-ui-1.12.1.custom/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="lib/jquery-ui-1.12.1.custom/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/bacheca.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title><?=$title?></title>
    <script type="text/javascript" src="lib/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="lib/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/bacheca.js"></script>
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

          <?php if (isset($_SESSION["user"])): ?>
            <div class="mb1">
              <button type="button" id="answer">Rispondi</button>
            </div>
          <?php endif;?>

          <?php if (count($answers)): ?>
            <?php foreach ($answers as $answer): ?>
              <div class="answer">
                <?=$pd->text($answer["content"])?>
                <div class="klein">
                  <span><?=$answer["name"]?></span>,
                  <time datetime="<?=$answer["uDateTime"]?>"><?=date_format(date_create($answer["uDateTime"]), "d/m/Y")?></time>
                </div>
              </div>
            <?php endforeach;?>
          <?php endif;?>
        </article>
      <?php elseif (count($boards)): ?>
        <?php if (isset($_SESSION["user"])): ?>
          <div class="mb1">
            <button type="button" id="write">Scrivi</button>
          </div>
        <?php endif;?>

        <div id="boards">
          <?php foreach ($boards as $board): ?>
            <a href="bacheca.php?id=<?=$board["id"]?>">
              <section>
                <header>
                  <h3><?=$board["title"]?></h3>
                </header>
                <div class="content">
                  <?=$pd->text(strlen($board["content"]) > 100 ? substr($board["content"], 0, 100) . "&hellip;" : $board["content"])?>
                </div>
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

        <div id="dialog-new" title="Crea nuovo messaggio" style="display: none;">
          <form>
            <fieldset>
              <label for="title">Titolo</label>
              <input id="title" type="text" value="" placeholder=""/>
              <label for="content">Testo</label>
              <textarea id="content" rows="8" cols="40" placeholder="Messaggio"></textarea>
              <p id="response"></p>
            </fieldset>
          </form>
        </div>
      <?php endif;?>
    </main>
  </body>
</html>
