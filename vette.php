<?php
session_start();

require_once "ajax/database.php";
require_once "php/formatParagraphs.php";
require_once "php/concatRefs.php";

$error           = null;
$peakList        = null;
$printPeak       = false;
$title           = "Le vette";
$description     = "";
$datetime        = "";
$height          = "";
$headTitle       = "Le vette delle Alpi Apuane";
$metaDescription = "Lista delle vette delle Alpi Apuane con informazioni.";

// Open db connection
$db = open_db();
// On error return null
if (!$db) {
    $error = "<p>Errore durante l'apertura del database</p>";
} else {
    $peakId = $_GET["id"];
    if ($peakId) {
        // Ricava le informazioni sulla vetta specificata
        $ret = $db->query("
          SELECT
            p.uDateTime,
            p.title,
            p.description,
            p.height,
            p.province,
            GROUP_CONCAT(h.name, '/', h.id
              SEPARATOR ',') AS huts
          FROM peaks p
          INNER JOIN peaks_huts ph ON ph.idPeak=p.id
          INNER JOIN huts h ON h.id = ph.idHut
          WHERE p.id = '$peakId'
        ");
        $peak = $ret->fetch_assoc();
        if ($peak) {
            $title           = $peak["title"];
            $headTitle       = $peak["title"];
            $metaDescription = $peak["description"];
            $description     = $peak["description"];
            $description     = preg_replace("/\*(.+?)\*/", "<strong>$1</strong>", $description);
            $datetime        = $peak["uDateTime"];
            $height          = $peak["height"];
            $province        = $peak["province"];
            $huts            = explode(",", $peak["huts"]);
            $printPeak       = true;
        } else {
            $error = "Vetta non trovata";
        }
    } else {
        // Stampa una lista da selezionare
        $ret = $db->query("
          SELECT id, title
          FROM peaks
          ORDER BY uDateTime DESC
        ");
        $peakList = $ret->fetch_all(MYSQLI_ASSOC);
    }
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
    <title><?=$headTitle?></title>
  </head>
  <body>
    <?php require "php/nav.php";?>

    <main>
      <?php if ($error): ?>
        <p class="error"><?=$error?></p>
      <?php endif;?>

      <?php if ($peakList): ?>
        <article class="mt1">
          <h3>Lista vette</h3>
          <ul class="block-list">
            <?php foreach ($peakList as $peak): ?>
              <li>
                <a
                  class="list-item"
                  href="vette.php?id=<?=$peak["id"]?>"
                  title="<?=$peak["title"]?>">
                  <?=$peak["title"]?>
                </a>
              </li>
            <?php endforeach;?>
          </ul>
        </article>
      <?php endif;?>

      <?php if ($printPeak): ?>
        <article class="mt1">
          <header>
            <h1><?=$title?></h1>
          </header>
          <img
            src="php/img.php?table=peaks&id=<?=$peakId?>"
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
                <td>Province</td>
                <td><?=$province?></td>
              </tr>
              <tr>
                <td>Rifugi</td>
                <td>
                  <?=concatRefs($huts, "rifugi.php")?>
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
