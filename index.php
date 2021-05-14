<?php
// print_r($_SERVER);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "lib/php/parsedown-master/Parsedown.php";
require_once "oop/place.class.php";
require_once "php/i18n.php";

$pd = new Parsedown();
$i18n = i18n("index");

$cPlace  = new Place();
$places = $cPlace->latest(0, 4);

?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Informazioni e curiosità sulle Alpi Apuane."/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/home.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title><?=$i18n["title"]?></title>
  </head>
  <body>
    <header>
      <h1><?=$i18n["h1"]?></h1>
    </header>

    <?php require "php/nav.php";?>

    <main>
      <?php foreach ($places as $place): ?>
        <article class="">
          <h2><?=$place["name"]?></h2>
          <!-- Check if place has image -->
          <?php if ($place["image"]): ?>
            <img
              src="img.php?table=places&id=<?=$place["id"]?>"
              alt="<?=$place["title"]?>">
          <?php endif;?>
          <!-- Place description -->
          <?=$pd->text($place["description"])?>
          <!-- Bottoni -->
          <div class="button-container">
            <a
              href="luoghi.php?id=<?=$place["id"]?>"
              title="<?=$place["title"]?>"
              ><?=$i18n["read"]?></a>
          </div>
          <!-- Footer -->
          <footer class="clear">
            <p>(<time datetime="<?=$place["uDateTime"]?>"><?=date_format(date_create($place["uDateTime"]), $i18n["dtformat"])?></time>)</p>
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
