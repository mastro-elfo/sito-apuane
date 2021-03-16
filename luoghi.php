<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "php/database.php";
require_once "lib/php/parsedown-master/Parsedown.php";
require_once "php/place.class.php";

$pd = new Parsedown();

// Inizializzo variabili di pagina
$error       = null;
$title       = "Luoghi";
$description = "I luoghi sulle Alpi Apuane";
$h1          = "";
$article     = "";
$datetime    = "";
$related     = [];
$tags        = [];
$attributes  = [];
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
    // Create a new class `Place`
    $place = new Place($placeId);
    // Read from db
    if ($place->read()) {
        $title       = $place->title;
        $description = $place->description;
        $h1          = $place->name;
        $article     = $place->article;
        $datetime    = $place->uDateTime;
        $showPlace   = true;
        // Load related places
        $place->readRelated();
        $related = $place->related;
        // Load tags
        $place->readTags();
        $tags = $place->tags;
        // Load attributes
        $place->readAttributes();
        $attributes = $place->attributes;
    } else {
        $errore = "Errore nel database";
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
          <h2><?=$h1?></h2>
          <img
            src="php/img.php?table=places&id=<?=$placeId?>"
            alt="<?=$title?>"/>

          <?=$pd->text($article)?>

          <?php if (count($related)): ?>
            <section>
              <h3>Vedi anche</h3>
              <p>
                <?php foreach ($related as $item): ?>
                  <a href="luoghi.php?id=<?=$item["id"]?>"><?=$item["name"]?></a>
                <?php endforeach;?>
              </p>
            </section>
          <?php endif;?>

          <?php if (count($attributes)): ?>
            <section>
              <h3>Dati</h3>
              <table>
                <tbody>
                  <?php foreach ($attributes as $attr): ?>
                    <tr>
                      <th><?=$attr["name"]?></th>
                      <td><?=$attr["value"] . $attr["after"]?></td>
                    </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </section>
          <?php endif;?>

          <?php if (count($tags)): ?>
            <p class="mt1">
              <?php foreach ($tags as $tag): ?>
                <span class="tag"
                  style="background-color: <?=$tag['color']?>; color:<?=$tag["textColor"]?>">
                  <?=$tag["name"]?>
                </span>
              <?php endforeach;?>
            </p>
          <?php endif;?>

          <footer>
            <p>
              <time datetime="<?=$datetime?>">
                (<?=date_format(date_create($datetime), "d/m/Y")?>)
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
