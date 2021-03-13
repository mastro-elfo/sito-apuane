<?php
session_start();

require_once "ajax/database.php";
require_once "php/formatParagraphs.php";

// Inizializzo variabili di pagina
$error       = null;
$title       = "Luoghi";
$description = "I luoghi sulle Alpi Apuane";
$h1          = "";
$article     = "";
$datetime    = "";
$showPlace   = false;
$places      = [];

//
$placeId = $_GET["id"];
// Open db connection
$db = open_db();
// On error
if (!$db) {
    $error = "Errore durante l'apertura del database";
}

if ($placeId) {
    // Se ho un id, carico le informazioni sul luogo specificato
    $ret = $db->query("
      SELECT
        p.name, p.article, p.title, p.description, p.uDateTime
      FROM places p
      WHERE p.id = '$placeId'
        AND p.deleted = 0
    ");
    $place = $ret->fetch_assoc();
    if ($place) {
        $title       = $place["title"];
        $description = $place["description"];
        $h1          = $place["name"];
        $article     = $place["article"];
        $datetime    = $place["uDateTime"];
        $showPlace   = true;
    } else {
        // TODO: Not Found
    }
} else {
    // Carico la lista dei luoghi
    $ret = $db->query("
      SELECT id, name, title
      FROM places
      WHERE deleted = 0
      ORDER BY uDateTime DESC
      LIMIT 10
    ");
    $places = $ret->fetch_all(MYSQLI_ASSOC);
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
        <p class="error"><?=$error?></p>
      <?php endif;?>

      <?php if ($showPlace): ?>
        <article>
          <header>
            <h1><?=$h1?></h1>
          </header>
          <section>
            <img
              src="php/img.php?table=places&id=<?=$placeId?>"
              alt="<?=$title?>"/>
            <?=formatParagraphs($article)?>
          </section>
          <footer>
            <p>
              <time datetime="<?=$datetime?>">
                (<?=$datetime?>)
              </time>
            </p>
          </footer>
        </article>
      <?php else: ?>
        <?php if ($places): ?>
          <ul class="block-list">
            <?php foreach ($places as $place): ?>
              <li>
                <a
                  class="list-item"
                  href="luoghi.php?id=<?=$place["id"]?>"
                  title="<?=$place["title"]?>">
                  <?=$place["name"]?>
                </a>
              </li>
            <?php endforeach;?>
          </ul>
        <?php endif;?>
      <?php endif;?>
    </main>
  </body>
</html>
