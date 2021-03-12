<?php
session_start();
require_once "ajax/database.php";
require_once "php/formatParagraphs.php";
require_once "php/concatRefs.php";

$hutId = $_GET["id"];

$error           = null;
$hutList         = null;
$printHut        = false;
$h1              = "Rifugi";
$title           = "I rifugi sulle Alpi Apuane";
$description     = "";
$metaDescription = "I rifugi sulle Alpi Apuane.";
$datetime        = null;
$height          = null;
$peaks           = "";

// Open db connection
$db = open_db();
// On error return null
if (!$db) {
    $error = "<p>Errore durante l'apertura del database</p>";
} else if ($hutId) {
    $ret = $db->query("
    SELECT
      h.uDateTime,
      h.name,
      h.description,
      h.height,
      GROUP_CONCAT(p.title, '/', p.id
        SEPARATOR ',') AS peaks
    FROM huts h
    INNER JOIN peaks_huts ph ON ph.idHut=h.id
    INNER JOIN peaks p ON p.id = ph.idPeak
    WHERE h.id = '$hutId'
    GROUP BY h.id
  ");
    $hut = $ret->fetch_assoc();
    if ($hut) {
        $h1              = $hut["name"];
        $title           = $hut["name"];
        $metaDescription = $hut["description"];
        $description     = $hut["description"];
        $datetime        = $hut["uDateTime"];
        $height          = $hut["height"];
        $peaks           = explode(",", $hut["peaks"]);
        $printHut        = true;
    } else {
        $error = "Rifugio non trovato";
    }
} else {
    $ret = $db->query("
    SELECT id, name
    FROM huts
    ORDER BY uDateTime DESC
  ");
    $hutList = $ret->fetch_all(MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="<?=$metaDescription?>"
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title><?=$title?></title>
  </head>
  <body>
    <?php require "php/nav.php";?>

    <main>
      <?php if ($error): ?>
        <p class="error p1"><?=$error?></p>
      <?php endif;?>

      <?php if ($hutList): ?>
        <h3>Lista rifugi</h3>
        <ul class="block-list">
          <?php foreach ($hutList as $hut): ?>
            <li>
              <a
                class="list-item"
                href="rifugi.php?id=<?=$hut["id"]?>"
                title="<?=$hut["name"]?>">
                  <?=$hut["name"]?>
                </a>
            </li>
          <?php endforeach;?>
        </ul>
      <?php endif;?>

      <?php if ($printHut): ?>
        <article class="mt1">
          <header>
            <h1><?=$h1?></h1>
          </header>

          <img
            src="php/img.php?table=huts&id=<?=$hutId?>"
            alt="<?=$title?>"/>
          <?=formatParagraphs($description)?>

          <h2>Informazioni</h2>
          <table>
            <tbody>
              <tr>
                <td>Altezza</td>
                <td><?=$height?>m s.l.m</td>
              </tr>
              <tr>
                <td>Vette</td>
                <td>
                  <?=concatRefs($peaks, "vette.php")?>
                </td>
              </tr>
            </tbody>
          </table>

          <footer>
            <p><?=$datetime?></p>
          </footer>
        </article>
      <?php endif;?>
    </main>
  </body>
</html>
