<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();

require_once "ajax/database.php";
require_once "php/formatParagraphs.php";
require_once "php/concatRefs.php";
require_once "php/concatTags.php";

// Inizializzo variabili di pagina
$error       = null;
$title       = "Luoghi";
$description = "I luoghi sulle Alpi Apuane";
$h1          = "";
$article     = "";
$datetime    = "";
$related     = [];
$tags        = [];
$showPlace   = false;
$places      = [];

//
$placeId = array_key_exists("id", $_GET) ? $_GET["id"] : null;
// Open db connection
$db = open_db();
// On error
if (!$db) {
    $error = "Errore durante l'apertura del database";
}

if ($placeId) {
    // Se ho un id, carico le informazioni sul luogo specificato
    $query = "
      SELECT
        p.name, p.article, p.title, p.description, p.uDateTime,
        (
            SELECT
            	GROUP_CONCAT(o.id, '/', o.name
          			SEPARATOR ',')
            FROM places o
            INNER JOIN places_places pp ON pp.idTo = o.id
            WHERE pp.idFrom = p.id
                AND pp.deleted = 0
        		    AND o.deleted = 0
        ) AS related,
        (
            SELECT
            	GROUP_CONCAT(t.id, '/', t.name, '/', t.color, '/', t.textColor
          			SEPARATOR ',')
            FROM tags t
            INNER JOIN places_tags pt ON pt.idTag = t.id
            WHERE
            	pt.idPlace = p.id
            	AND t.deleted = 0
            	AND pt.deleted = 0
        ) AS tags
      FROM places p
      WHERE p.id = '$placeId'
        AND p.deleted = 0
    ";
    $ret = $db->query($query);
    if ($ret) {
        $place = $ret->fetch_assoc();
        if ($place) {
            $title       = $place["title"];
            $description = $place["description"];
            $h1          = $place["name"];
            $article     = $place["article"];
            $datetime    = $place["uDateTime"];
            $related     = array_filter(explode(",", $place["related"]), function ($in) {return $in;});
            $tags = array_filter(explode(",", $place["tags"]), function ($in) {return $in;});
            $showPlace = true;
        } else {
            $error = "Non ho trovato questo luogo";
        }
    } else {
        $error = "Errore nella query: $query";
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
        <p class="error p1"><?=$error?></p>
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
          <section>
            <?php if (count($related)): ?>
              <h2>Vedi anche</h2>
              <?=count($related)?>
              <?php print_r($related);?>
              <?=concatRefs($related, "luoghi.php")?>
            <?php endif;?>

            <?php if (count($tags)): ?>
              <h2>Tag</h2>
              <?=concatTags($tags)?>
            <?php endif;?>
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
