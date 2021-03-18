<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Consulta il meteo locale per programmare un'escurzione in sicurezza."
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/meteo.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title>Il meteo sulle Alpi Apuane</title>
    <script src="lib/jquery-3.6.0.js"></script>
    <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="js/meteo.js"></script>
  </head>
  <body>
    <header>
      <h1>Meteo locale</h1>
    </header>

    <?php require "php/nav.php";?>

    <main>
      <div class="center mt1">
        <div id="map-container" class="radius1" style="width: 400px; height: 300px;">
        </div>
      </div>
    </main>
  </body>
</html>
