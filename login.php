<?php

require_once "php/i18n.php";

$i18n = i18n("login");

?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="<?=$i18n["description"]?>"
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/accesso.css" />
    <link rel="stylesheet" href="lib/js/SnackBar-master/dist/snackbar.min.css">
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title><?=$i18n["title"]?></title>
    <script src="lib/js/jquery-3.6.0.js"></script>
    <script src="lib/js/SnackBar-master/dist/snackbar.min.js"></script>
    <script src="js/snackbar.js"></script>
    <script src="js/accesso.js"></script>
  </head>
  <body>
    <?php require "php/nav.php";?>

    <main>
      <form id="login">
        <fieldset>
          <label for="username"><?=$i18n["username"]?></label>
          <input
            type="email"
            id="username"
            name="username"
            value=""
            autofocus
            class="mb1"/>
          <label for="password"><?=$i18n["password"]?></label>
          <input
            type="password"
            id="password"
            name="password"
            value=""
            class="mb1"/>
          <div class="button-container">
            <button type="submit" class="bSuccess"><?=$i18n["login"]?></button>
            <a
              href="registrazione.php"
              class="button bWarning"
              ><?=$i18n["signup"]?></a>
          </div>
        </fieldset>
      </form>
    </main>
  </body>
</html>
