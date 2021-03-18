<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "lib/php/parsedown-master/Parsedown.php";
require_once "php/place.class.php";

$pd = new Parsedown();
// Inizializzo variabili di pagina
$error       = null;
$title       = "Luoghi";
$description = "I luoghi sulle Alpi Apuane";
$h1          = "";
$article     = "";
$image       = false;
$datetime    = "";
$related     = [];
$tags        = [];
$attributes  = [];
$showPlace   = false;
$places      = [];

//
$placeId = array_key_exists("id", $_GET) ? $_GET["id"] : null;
// Create a new class `Place`
$place = new Place($placeId);

if ($placeId) {
    // Read from db
    if ($place->read()) {
        $title       = $place->title;
        $description = $place->description;
        $h1          = $place->name;
        $article     = $place->article;
        $datetime    = $place->uDateTime;
        $image       = $place->image;
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
    $places = $place->readAll();
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
        <!-- Stampa in caso di errore -->
        <p class="error p1"><?=$error?></p>
      <?php endif;?>

      <?php if ($showPlace): ?>
        <!-- Visualizzazione luogo -->
        <article>
          <h2><?=$h1?></h2>
          <?php if ($image): ?>
            <!-- Inserisci l'immagine se presente -->
            <img
              src="php/img.php?table=places&id=<?=$placeId?>"
              alt="<?=$image?>"/>
          <?php endif;?>

          <?=$pd->text($article)?>

          <?php if (count($related)): ?>
            <!-- Luoghi correlati -->
            <section>
              <h3>Vedi anche</h3>
              <p>
                <?php foreach ($related as $key => $item): ?>
                  <a
                    href="luoghi.php?id=<?=$item["id"]?>"
                    title="Vedi <?=$item["name"]?>"><?=$item["name"]?></a><?=$key < count($related) - 1 ? ", " : ""?>
                <?php endforeach;?>
              </p>
            </section>
          <?php endif;?>

          <?php if (count($attributes)): ?>
            <!-- Attributi -->
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
            <!-- Lista dei tag -->
            <p class="mt1">
              <?php foreach ($tags as $tag): ?>
                <span class="tag mr1"
                  style="background: <?=$tag['color']?>; color:<?=$tag["textColor"]?>"><?=$tag["name"]?></span>
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
          <!-- Visualizzazione lista -->
          <ul class="block-list">
            <?php foreach ($places as $place): ?>
              <li>
                <a
                  class="list-item"
                  href="luoghi.php?id=<?=$place["id"]?>"
                  title="<?=$place["title"]?>">
                  <?=$place["name"]?>
                  <?php if ($place["tags"]): ?>
                    <?php foreach (explode(",", $place["tags"]) as $tag): ?>
                      <?php $parts = explode("/", $tag);?>
                      <span class="tag right klein ml1"
                        style="background:<?=$parts[1]?>;color:<?=$parts[2]?>"><?=$parts[0]?></span>
                    <?php endforeach;?>
                  <?php endif;?>
                </a>
              </li>
            <?php endforeach;?>
          </ul>
        <?php endif;?>
      <?php endif;?>
    </main>
  </body>
</html>
