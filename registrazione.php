<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="lib/js/SnackBar-master/dist/snackbar.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title>Registrazione</title>
    <script src="lib/js/jquery-3.6.0.js"></script>
    <link rel="stylesheet" href="lib/js/passfield-1.1.15/dist/css/passfield.min.css">
    <script src="lib/js/passfield-1.1.15/dist/js/passfield.min.js"></script>
    <script type="text/javascript">
    $(function($){
      $('input[type="password"]').passField({
        pattern: "aB$3aB$3"
      });
    })
    </script>
    <script src="lib/js/SnackBar-master/dist/snackbar.min.js" charset="utf-8"></script>
    <script src="js/snackbar.js" charset="utf-8"></script>
    <script src="js/registrazione.js"></script>
  </head>
  <body>
    <?php require("php/nav.php"); ?>

    <main>
      <form id="registrazione" action="ajax/registrazione.php" method="post">
        <fieldset>
          <label for="name">Nome</label>
          <input type="text" name="name" value="" placeholder="">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" value="" placeholder="">
          <label for="password">Password</label>
          <input type="password" name="password" value="" placeholder="">
          <div class="button-container py1">
            <button
              type="submit"
              name="action"
              value="signup"
              class="bSuccess"
              >Registrami</button>
          </div>
        </fieldset>
      </form>

      <footer></footer>
    </main>
  </body>
</html>
