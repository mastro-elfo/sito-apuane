<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Controllo accesso
if (!array_key_exists("user", $_SESSION)) {
    header("Location: login.php?");
    exit;
}

// Controllo permessi
require_once "php/admin.php";
if (!isAdmin()) {
    header("Location: login.php?error=" . urlencode("Non sei amministratore"));
    exit;
}

$error      = null;
$placeId    = array_key_exists("id", $_GET) ? $_GET["id"] : null;
$place      = [];
$attributes = [];
// Controllo richiesta
if ($placeId) {
    require_once "oop/attribute.class.php";
    require_once "oop/attrtype.class.php";
    require_once "oop/place.class.php";
    require_once "oop/tag.class.php";

    $cPlace = new Place($placeId);
    $place  = $cPlace->read();
    // $tags = (new Tag)->ofPlace($placeId);
    $attributes = (new MyAttribute)->ofPlace($placeId);
    $attr_names = (new AttrType)->all();

}

if (!$place) {
    $error = "Richiesta non valida: '$placeId'";
}

?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/place_edit.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title>Modifica luogo</title>
  </head>
  <body>
    <?php require "php/nav.php";?>

    <main>
      <?php if ($error): ?>
        <!-- Stampa in caso di errore -->
        <p class="error p1"><?=$error?></p>
      <?php endif;?>
      <!-- Place editor -->
      <?php if ($place): ?>
          <form>
            <fieldset>
              <label for="name">Nome</label>
              <input
                type="text"
                id="name"
                value="<?=$place["name"]?>"
                class="mb1">
              <label for="title">Titolo</label>
              <input
                type="text"
                id="title"
                value="<?=$place["title"]?>"
                class="mb1">
              <label for="description">Descrizione</label>
              <textarea
                id="description"
                rows="8"
                cols="80"
                class="mb1"><?=$place["description"]?></textarea>
              <label for="article">Articolo</label>
              <textarea
                id="article"
                rows="8"
                cols="80"
                class="mb1"><?=$place["article"]?></textarea>
              <label for="image">Immagine</label>
              <input type="file" id="image" value="" class="mb1">
              <label>Attributi</label>
              <table class="mb1">
                <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Valore</th>
                    <th>Dopo</th>
                    <th>Elim.</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($attributes as $attr): ?>
                    <tr>
                      <td>
                        <select>
                          <?php foreach ($attr_names as $attr_name): ?>
                            <option
                              value="<?=$attr_name["name"]?>"
                              <?=$attr_name["name"] == $attr["name"] ? "selected" : ""?>
                              ><?=$attr_name["name"]?></option>
                          <?php endforeach;?>
                        </select>
                      </td>
                      <td>
                        <input type="text" value="<?=$attr["value"]?>">
                      </td>
                      <td>
                        <input type="text" value="<?=$attr["after"]?>">
                      </td>
                      <td>
                        <input type="checkbox" value="<?=$attr["id"]?>">
                      </td>
                    </tr>
                  <?php endforeach;?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4">
                      <button
                        type="button"
                        class="klein bSuccess"
                        >Nuovo</button>
                      </td>
                  </tr>
                </tfoot>
              </table>

              <label>Tag</label>

              <div class="button_container py1">
                  <button type="button" class="bSuccess">Salva</button>
              </div>
            </fieldset>
          </form>
      <?php endif;?>
    </main>
    <footer class="py1"></footer>
  </body>
</html>
