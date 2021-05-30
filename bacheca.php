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
require_once "oop/answer.class.php";
require_once "oop/board.class.php";
require_once "php/i18n.php";

$pd = new Parsedown();
$i18n = i18n("board");

// Inizializzo variabili di pagina
$error       = array_key_exists("error", $_GET) ? $_GET["error"] : "";
$title       = $i18n["title"];
$description = $i18n["description"];
$h1          = "";
$article     = "";
$author      = "";
$datetime    = "";
$showBoard   = false;
$boards      = [];
$answers     = [];
//
$boardId        = array_key_exists("id", $_GET) ? $_GET["id"] : null;
$searchByUserId = array_key_exists("byUser", $_GET) ? $_SESSION["user"]["id"] : null;
$searchByQuery  = array_key_exists("q", $_GET) ? $_GET["q"] : null;
//
$cBoard  = new Board($boardId);
$cAnswer = new Answer();

if ($boardId) {
    $board = $cBoard->read();
    if ($board) {
        $title       = $board["title"];
        $description = $board["content"];
        $h1          = $board["title"];
        $article     = $board["content"];
        $author      = $board["user_name"];
        $datetime    = $board["uDateTime"];
        $showBoard   = true;
        $answers     = $cAnswer->toBoard($boardId);
    } else {
        $error = $i18n["error_404"];
    }
} else {
    // Carico la lista dei messaggi
    $boards = $cBoard->search($searchByQuery, $searchByUserId);
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
    <!-- <link rel="stylesheet" href="lib/js/jquery-ui-1.12.1.custom/jquery-ui.min.css"> -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/bacheca.css" />
    <link rel="stylesheet" href="lib/js/SnackBar-master/dist/snackbar.min.css">
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title><?=$title?></title>
    <script src="lib/js/jquery-3.6.0.js"></script>
    <script src="lib/js/SnackBar-master/dist/snackbar.min.js"></script>
    <script src="js/snackbar.js"></script>
    <script src="js/bacheca.js"></script>
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
            <!-- Buttons -->
            <div class="button-container mb1">
              <!-- Answer this message -->
              <a
                href="bacheca_rispondi.php?boardId=<?=$board["id"]?>"
                class="button bSuccess"
                ><?=$i18n["answer"]?></a>
              <!-- If user is owner, add the edit and delete button -->
              <?php if ($_SESSION["user"]["id"] == $board["user_id"]): ?>
                <!-- Edit this message -->
                <a
                  class="button bWarning"
                  href="bacheca_scrivi.php?id=<?=$board["id"]?>"
                  ><?=$i18n["edit"]?></a>
                <!-- Delete this message -->
                <button
                  type="button"
                  class="bDanger"
                  data-delete-board="<?=$board["id"]?>"
                  ><?=$i18n["delete"]?></button>
              <?php endif;?>
            </div>
          <?php endif;?>

          <?php if (count($answers)): ?>
            <?php foreach ($answers as $answer): ?>
              <div class="answer">
                <?=$pd->text($answer["content"])?>
                <div class="klein">
                  <span><?=$answer["name"]?></span>,
                  <time
                    datetime="<?=$answer["uDateTime"]?>"
                    ><?=date_format(date_create($answer["uDateTime"]), $i18n["date_format"])?></time>
                </div>
                <!-- Buttons -->
                <div class="button-container">
                  <!-- This is a placeholder that move the next button to the right -->
                  <span></span>
                  <?php if (isset($_SESSION["user"]) && $answer["idUser"] == $_SESSION["user"]["id"]): ?>
                    <a
                      class="button bWarning"
                      data-board-id="<?=$board["id"]?>"
                      data-answer-id="<?=$answer["id"]?>"
                      href="bacheca_rispondi.php?boardId=<?=$board["id"]?>&answerId=<?=$answer["id"]?>"
                      ><?=$i18n["edit"]?></a>
                    <button
                      type="button"
                      class="bDanger"
                      data-delete-answer="<?=$answer["id"]?>"
                      ><?=$i18n["delete"]?></button>
                  <?php endif;?>
                </div>
              </div>
            <?php endforeach;?>
          <?php endif;?>
        </article>
      <?php elseif (count($boards)): ?>
        <!-- Lista dei messaggi -->
        <?php if (isset($_SESSION["user"])): ?>
          <div class="button-container p1">
            <a
              href="bacheca_scrivi.php"
              class="button bSuccess"
              ><?=$i18n["write"]?></a>
            <a
              class="button bWarning"
              href="bacheca.php?<?=$searchByUserId ? "" : "byUser"?>"
              ><?=$searchByUserId ? "-" : "+"?> <?=$i18n["filter"]?></a>
            <span></span>
          </div>
        <?php endif;?>

        <div id="boards">
          <?php foreach ($boards as $board): ?>
            <div class="mb1">
              <a href="bacheca.php?id=<?=$board["id"]?>" title="Apri <?=$board["title"]?>" class="mt1">
                <section>
                  <header>
                    <h3><?=$board["title"]?></h3>
                  </header>
                  <div class="content">
                    <?=$pd->text(strlen($board["content"]) > 200 ? substr($board["content"], 0, 200) . "&hellip;" : $board["content"])?>
                  </div>
                  <footer>
                    <p>
                      <?=$board["user_name"]?>,
                      <time datetime="<?=$board["uDateTime"]?>">
                        <?=date_format(date_create($board["uDateTime"]), $i18n["date_format"])?></time>,
                      <?php if ($board["answers"] == 1): ?>
                        <span><?=$board["answers"]?> <?=$i18n["1answer"]?></span>
                      <?php else: ?>
                        <span><?=$board["answers"]?> <?=$i18n["2answers"]?></span>
                      <?php endif;?>
                    </p>
                  </footer>
                </section>
              </a>
            </div>
          <?php endforeach;?>
        </div>
      <?php endif;?>
    </main>
  </body>
</html>
