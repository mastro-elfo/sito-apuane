<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Profilo utente."
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title>Profilo utente</title>
    <script type="text/javascript" src="lib/jquery-3.6.0.js"></script>
    <script src="js/profilo.js"></script>
  </head>
  <body>
    <?php require "php/nav.php";?>

    <main>
      <ul class="style-none mt1">
        <li class="mb1 px1">
          <label for="name">Nome</label>
          <input type="text" name="name" id="name" value="<?=$_SESSION['user']['name']?>" placeholder="Scrivi il tuo nome"/>
        </li>
        <li class="mb1 px1">
          <label for="email">Email</label>
          <input type="text" name="email" id="email" value="<?=$_SESSION['user']['email']?>" placeholder="Scrivi il tuo indirizzo email">
        </li>
        <li class="mb1 px1"><button type="button" id="save">Salva</button></li>
        <li class="mb1 px1">
          <button type="button" name="button" id="logout" class="danger">Logout</button>
        </li>
        <li class="mb1 px1">
          <span id="response"></span>
        </li>
      </ul>
    </main>
  </body>
</html>
