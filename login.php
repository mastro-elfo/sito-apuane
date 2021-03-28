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
    <link rel="stylesheet" href="lib/js/SnackBar-master/dist/snackbar.min.css">
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title>Accesso al sito</title>
    <script type="text/javascript" src="lib/js/jquery-3.6.0.js"></script>
    <script src="lib/js/SnackBar-master/dist/snackbar.min.js" charset="utf-8"></script>
    <script src="js/snackbar.js" charset="utf-8"></script>
    <script type="text/javascript" src="js/accesso.js"></script>
  </head>
  <body>
    <?php require "php/nav.php";?>

    <main>
      <form id="login">
        <fieldset>
          <label for="username">Username</label>
          <input
            type="email"
            id="username"
            name="username"
            value=""
            autofocus
            class="mb1"/>
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            value=""
            class="mb1"/>
          <div class="button-container">
            <button type="submit" class="bSuccess">Login</button>
            <a
              type="button"
              href="registrazione.php"
              class="bWarning"
              >Registrati</a>
          </div>
          <p id="response" class="klein my1"></p>
        </fieldset>
      </form>
    </main>
  </body>
</html>
