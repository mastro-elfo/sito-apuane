<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$error  = "";
$data   = null;
$places = null;

if (array_key_exists("login", $_POST)) {
    // Includo la classe User
    require_once "oop/user.class.php";
    require_once "oop/place.class.php";
    // Instanzio l'oggetto
    $user = new User();
    // Chiamo il metodo login
    $data = $user->login($_POST["username"], $_POST["password"]);
    // Verifico l'output della funzione
    if (!$data) {
        $error = "Errore, login fallito";
    }
}

?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <p class="error">
      <?=$error?>
    </p>

    <p>
      <?php print_r($data);?>
    </p>

    <p><?php print_r($places);?></p>

    <form action="login.php" method="post">
      <fieldset>
        <label for="username">Username</label>
        <input type="text" name="username" value="" placeholder="Username">
        <label for="password">Password</label>
        <input type="password" name="password" value="" placeholder="Password">

        <input type="submit" name="login" value="login">
      </fieldset>
    </form>
  </body>
</html>
