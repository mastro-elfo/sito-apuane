<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Pagina di accesso all'area riservata del sito."
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/accesso.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title>Accesso al sito</title>
    <script type="text/javascript" src="lib/jquery-3.6.0.js"></script>
    <script src="js/accesso.js"></script>
  </head>
  <body>
    <?php require "php/nav.php";?>

    <main>
      <form id="login" action="accesso.html" method="post">
        <fieldset>
          <label for="username">Username</label>
          <input type="email" id="username" name="username" value="" autofocus />
          <label for="password">Password</label>
          <input type="password" id="password" name="password" value="" />
          <button type="submit">Login</button>
          <button type="button" onclick="location.href = 'registrazione.php';">Registrati</button>
          <p id="response"></p>
        </fieldset>
      </form>
    </main>
  </body>
</html>
