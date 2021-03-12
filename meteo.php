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
  </head>
  <body>
    <header>
      <h1>Meteo locale</h1>
    </header>

    <?php require "php/nav.php";?>

    <main>
      <div class="center mt1">
        <div id="map-container" class="radius1">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d91828.68237555372!2d10.325464485156232!3d44.00803676851321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12d572cc9cb70fa1%3A0x27023452f940372d!2sParco%20Alpi%20Apuane!5e0!3m2!1sit!2sit!4v1615541306206!5m2!1sit!2sit" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
    </main>
  </body>
</html>
