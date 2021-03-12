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
      content="Lista dei percorsi sulle Alpi Apuane con informazioni."
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title>I percorsi sulle Alpi Apuane</title>
  </head>
  <body>

    <?php require "php/nav.php";?>

    <main>
      <?php if ($error): ?>
        <p class="error"><?=$error?></p>
      <?php endif;?>

      <?php if ($pathList): ?>
        <h3>Lista percorsi</h3>
        <ul class="block-list">
          <?php foreach ($pathList as $path): ?>
            <li>
              <a
                class="list-item"
                href="percorsi.php?id=<?=$path["id"]?>"
                title="<?=$path["title"]?>">
                <?=$path["title"]?>
              </a>
            </li>
          <?php endforeach;?>
        </ul>
      <?php endif;?>

      <?php if ($printPath): ?>
        <article class="mt1">
          <header>
            <h1><?=$title?></h1>
          </header>
        </article>
      <?php endif;?>
    </main>
  </body>
</html>
