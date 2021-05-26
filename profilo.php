<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!array_key_exists("user", $_SESSION)) {
    header("Location: login.php");
    exit;
}

require_once "php/i18n.php";
$i18n = i18n("profile");

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
    <link rel="stylesheet" href="lib/js/SnackBar-master/dist/snackbar.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title><?=$i18n["title"]?></title>
    <script src="lib/js/jquery-3.6.0.js"></script>
    <script src="lib/js/SnackBar-master/dist/snackbar.min.js"></script>
    <script src="js/snackbar.js"></script>
    <script src="js/profilo.js"></script>
  </head>
  <body>
    <?php require "php/nav.php";?>

    <main>
      <ul class="style-none mt1">
        <?php if (array_key_exists("admin", $_SESSION['user']) && $_SESSION['user']['admin']): ?>
          <li class="mb1 px1">
            <label><?=$i18n["admin"]?></label>
          </li>
        <?php endif;?>
        <li class="mb1 px1">
          <label><?=$i18n["yourmessages"]?></label>
          <a href="bacheca.php?byUser"><?=$i18n["read"]?></a>
        </li>
        <li class="mb1 px1">
          <label for="name"><?=$i18n["name"]?></label>
          <input
            type="text"
            name="name"
            id="name"
            value="<?=$_SESSION['user']['name']?>"
            placeholder="<?=$i18n["name_placeholder"]?>"/>
        </li>
        <li class="mb1 px1">
          <label for="email"><?=$i18n["email"]?></label>
          <input
            type="text"
            name="email"
            id="email"
            value="<?=$_SESSION['user']['email']?>"
            placeholder="<?=$i18n["email_placeholder"]?>">
        </li>
        <li class="mb1 px1 button-container">
          <button
            type="button"
            id="save"
            class="bSuccess">
            <?=$i18n["save"]?>
          </button>
          <button
            type="button"
            id="logout"
            class="bWarning">
            <?=$i18n["logout"]?>
          </button>
          <button
            type="button"
            id="delete"
            class="bDanger">
            <?=$i18n["delete"]?>
          </button>
        </li>
      </ul>
    </main>
  </body>
</html>
