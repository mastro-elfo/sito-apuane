<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "php/place.class.php";

// Create a new class `Place`
$place   = new Place();
$places  = $place->readCoordinates();
$markers = array_values(array_filter($places, function ($p) {
    return $p["latitudine"] && $p["longitudine"];
}));
?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="La mappa del parco delle Alpi Apuane."
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/mappa.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title>Mappa del parco</title>
    <script src="lib/jquery-3.6.0.js"></script>
    <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript">
      const markers = JSON.parse(<?=json_encode(json_encode($markers))?>);
    </script>
    <script type="text/javascript" src="js/mappa.js"></script>
  </head>
  <body>
    <?php require "php/nav.php";?>

    <main>
      <div class="center mt1">
        <div id="map-container" class="radius1">
        </div>
      </div>
    </main>
  </body>
</html>
