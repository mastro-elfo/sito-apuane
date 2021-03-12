<?php

session_start();

require_once "database.php";

function update($nome, $email){
  // Open db connection
    $db = open_db();
    // On error return null
    if (!$db) {
        return null;
    }
    // Get user id from session
    $userId = $_SESSION["user"]["id"];
    // Update record
    $db->query("
      UPDATE utenti
      SET
        nome = '$nome',
        email = '$email'
      WHERE
        id = '$userId'
    ");
    // Reload user record
    $ret = $db->query("
      SELECT id, nome, email
      FROM utenti
      WHERE
        id = '$userId'
    ");
    $user = $ret->fetch_assoc();
    // Update session variable
    if($user) {
      $_SESSION["user"] = $user;
    }
    return $user;
}

if ($_POST["action"] == "update") {
  echo json_encode(update($_POST["name"], $_POST["email"]));
}

 ?>
