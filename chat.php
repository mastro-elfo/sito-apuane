<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Chatta con gli altri utenti del sito." />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/chat.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title>Chat</title>
    <script src="js/ajax.js"></script>
    <script src="js/idListen.js"></script>
    <script src="js/chat.js"></script>
  </head>
  <body>
    <header>
      <h1>Chat</h1>
    </header>

    <?php require("php/nav.php"); ?>

    <main>
      <ul id="chat">
        <li>
          Carico gli ultimi messaggi...
          <footer>
            <span class="name">Il server</span>
          </footer>
        </li>
      </ul>
      <form action="chat.php" method="post" id="send">
        <fieldset>
          <select name="receiverId" id="receiverId"></select>
          <input
            type="text"
            name="message"
            id="message"
            value=""
            placeholder="Scrivi un messaggio"
          />
          <button type="submit" name="button">Invia</button>
        </fieldset>
      </form>
    </main>
  </body>
</html>
