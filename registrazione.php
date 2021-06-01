<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "php/i18n.php";
$i18n = i18n("signup");

?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="<?=$i18n["description"]?>"/>
    <link rel="stylesheet" href="lib/js/SnackBar-master/dist/snackbar.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title><?=$i18n["title"]?></title>
    <script src="lib/js/jquery-3.6.0.js"></script>
    <link rel="stylesheet" href="lib/js/passfield-1.1.15/dist/css/passfield.min.css">
    <script src="lib/js/passfield-1.1.15/dist/js/passfield.min.js"></script>
    <script>
    $(function($){
      $('input[type="password"]').passField({
        pattern: "aB$3aB$3"
      });
    })
    </script>
    <script src="lib/js/SnackBar-master/dist/snackbar.min.js"></script>
    <script src="js/snackbar.js"></script>
    <script src="js/registrazione.js"></script>
  </head>
  <body>
    <?php require("php/nav.php"); ?>

    <main>
      <form id="registrazione" action="ajax/registrazione.php" method="post">
        <fieldset>
          <label for="name"><?=$i18n["name"]?></label>
          <input type="text" name="name" id="name" value="" placeholder="">
          <label for="email"><?=$i18n["email"]?></label>
          <input type="email" name="email" id="email" value="" placeholder="">
          <label for="password"><?=$i18n["password"]?></label>
          <input type="password" name="password" id="password" value="" placeholder="">
          <div class="button-container py1">
            <button
              type="submit"
              name="action"
              value="signup"
              class="bSuccess"
              ><?=$i18n["signup"]?></button>
          </div>
        </fieldset>
      </form>

      <footer></footer>
    </main>
  </body>
</html>
