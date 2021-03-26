<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "lib/php/parsedown-master/Parsedown.php";
require_once "oop/attribute.class.php";
require_once "oop/place.class.php";
require_once "oop/tag.class.php";

// Init parser
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
// Turn this on to show the place article
$showPlace = false;
$places    = [];
// Search string
$search    = array_key_exists("q", $_GET) ? $_GET["q"] : null;
$tagFilter = array_key_exists("t", $_GET) ? $_GET["t"] : null;
// Place id
$placeId = array_key_exists("id", $_GET) ? $_GET["id"] : null;
// Create a new class `Place`
$cPlace = new Place($placeId);
// Switch view
if ($placeId) {
    // Read from db
    $place = $cPlace->read(["id", "name", "title", "description", "article", "!isnull(image) as image", "uDateTime"]);
    // Check return value
    if ($place) {
        $title       = $place["title"];
        $description = $place["description"];
        $h1          = $place["name"];
        $article     = $place["article"];
        $datetime    = $place["uDateTime"];
        $image       = $place["image"];
        $showPlace   = true;
        // Load related places
        $related = $cPlace->related();
        // Load tags
        $tags = (new Tag)->ofPlace($placeId);
        // // Load attributes
        $attributes = (new MyAttribute)->ofPlace($placeId);
    } else {
        $errore = "Errore nel database";
    }
} else {
    $places = $cPlace->search($search, $tagFilter);
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
          <!-- Title -->
          <h2><?=$h1?></h2>
          <?php if ($image): ?>
            <!-- Inserisci l'immagine se presente -->
            <img
              src="php/img.php?id=<?=$placeId?>"
              alt="<?=$image?>"/>
          <?php endif;?>
          <!-- Article content -->
          <?=$pd->text($article)?>
          <!-- Luoghi correlati -->
          <?php if (count($related)): ?>
            <section>
              <h3>Vedi anche</h3>
              <p>
                <?php foreach ($related as $key => $item): ?>
                  <a
                    href="luoghi.php?id=<?=$item["id"]?>"
                    title="Vedi <?=$item["name"]?>"
                    ><?=$item["name"]?></a><?=$key < count($related) - 1 ? ", " : ""?>
                <?php endforeach;?>
              </p>
            </section>
          <?php endif;?>
          <!-- Attributi -->
          <?php if (count($attributes)): ?>
            <section>
              <h3>Dati</h3>
              <table>
                <tbody>
                  <?php foreach ($attributes as $attr): ?>
                    <tr>
                      <th><?=$attr["name"]?></th>
                        <td>
                          <?php if(str_starts_with($attr["value"], "http")): ?>
                            <a
                              href="<?=$attr["value"] . $attr["after"]?>"
                              title="Apri link <?=$attr["value"] . $attr["after"]?>"
                              target="_blank"
                              ><?=$attr["value"] . $attr["after"]?></a>
                          <?php else: ?>
                            <?=$attr["value"] . $attr["after"]?>
                          <?php endif; ?>
                        </td>
                    </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </section>
          <?php endif;?>
          <!-- Lista dei tag -->
          <?php if (count($tags)): ?>
            <p class="mt1">
              <?php foreach ($tags as $tag): ?>
                <a
                  class="tag mr1"
                  style="background: <?=$tag['color']?>; color:<?=$tag["textColor"]?>"
                  href="luoghi.php?t=<?=$tag["name"]?>"
                  title="Cerca <?=$tag["name"]?>"
                  ><?=$tag["name"]?></a>
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
        <!-- Input di ricerca -->
        <form action="luoghi.php" method="get">
          <fieldset>
            <input
              type="text"
              name="q"
              value="<?=$search?>"
              placeholder="Ricerca">
          </fieldset>
        </form>
        <!-- Visualizzazione lista -->
        <?php if ($places): ?>
          <ul class="block-list">
            <?php foreach ($places as $place): ?>
              <li>
                <!-- List of tags -->
                <?php if ($place["tags"]): ?>
                  <div class="right mt-5 mr-5">
                    <?php foreach (explode(",", $place["tags"]) as $tag): ?>
                      <?php $parts = explode("/", $tag);?>
                      <a
                        class="tag klein ml1"
                        style="background:<?=$parts[1]?>;color:<?=$parts[2]?>"
                        href="luoghi.php?t=<?=$parts[0]?>"
                        title="Cerca <?=$parts[0]?>"
                        ><?=$parts[0]?></a>
                    <?php endforeach;?>
                  </div>
                <?php endif;?>
                <!-- Row -->
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
      <footer class="py1"></footer>
    </main>
  </body>
</html>
