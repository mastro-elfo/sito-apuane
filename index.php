<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "lib/php/parsedown-master/Parsedown.php";
require_once "php/place.class.php";

$pd = new Parsedown();

$place  = new Place();
$places = $place->readLatest(0, 4);

?>

<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Informazioni e curiosità sulle Alpi Apuane."
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/home.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title>Vette Apuane</title>
  </head>
  <body>
    <header>
      <h1>Alpi Apuane</h1>
    </header>

    <?php require "php/nav.php";?>

    <!-- <aside class="center">
      <video autoplay controls muted title="Un video sulla montagna">
        <source src="./video/montagna.mp4" type="video/mp4" />
      </video>
    </aside> -->

    <main>
      <?php foreach ($places as $place): ?>
        <article class="">
          <h2><?=$place["name"]?></h2>
          <!-- Check if place has image -->
          <?php if ($place["image"]): ?>
            <img
              src="php/img.php?table=places&id=<?=$place["id"]?>"
              alt="<?=$place["title"]?>">
          <?php endif;?>
          <!-- Place description -->
          <?=$pd->text($place["description"])?>
          <!-- Bottoni -->
          <div class="button-container">
            <a
              href="luoghi.php?id=<?=$place["id"]?>" 
              title="<?=$place["title"]?>">Leggi</a>
          </div>
          <!-- Footer -->
          <footer class="clear">
            <p>(<time datetime="<?=$place["uDateTime"]?>"><?=date_format(date_create($place["uDateTime"]), "d/m/Y")?></time>)</p>
          </footer>
        </article>
      <?php endforeach;?>
    </main>

    <footer>
      <p>
        Fonte: Wikipedia, visittuscany, finoincima.altervista.org,
        gettyimages.it
      </p>
    </footer>
  </body>
</html>
