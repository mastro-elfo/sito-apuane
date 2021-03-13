<?php
session_start();

require_once "database.php";

// Add new message to db
function send($receiverId, $message)
{
    if (!isset($_SESSION["user"])) {
        return null;
    }
    $userId = $_SESSION["user"]["id"];
    // Open db connection
    $db = open_db();
    // On error return null
    if (!$db) {
        return null;
    }
    // Insert message into db
    $db->query("
      INSERT INTO chat (idMittente, idDestinatario, messaggio)
      VALUES ('$userId', '$receiverId', '$message');
    ");
    // Query the last inserted row
    $ret = $db->query("
      SELECT
        messaggio,
        dataora,
        idMittente,
        u.nome as nomeMittente,
        idMittente = '$userId' as own
      FROM chat
      INNER JOIN users u ON u.id = idMittente
      WHERE chat.id = LAST_INSERT_ID();");
    // returns `null` on failure
    return $ret->fetch_assoc();
}

function read($user_2)
{
    if (!isset($_SESSION["user"])) {
        return null;
    }
    // Get user id from session
    $userId = $_SESSION["user"]["id"];
    // Open db connection
    $db = open_db();
    // On error return null
    if (!$db) {
        return null;
    }
    $ret = $db->query("
      SELECT * FROM (
        SELECT
          chat.id,
          messaggio,
          dataora,
          idMittente,
          u.nome as nomeMittente,
          idMittente = '$userId' as own
        FROM chat
        INNER JOIN users u on u.id = idMittente
        WHERE
             (idMittente = '$userId' AND idDestinatario = '$user_2')
          OR (idMittente = '$user_2' AND idDestinatario = '$userId')
        ORDER BY dataora DESC
        LIMIT 10
      ) as temp
      ORDER BY temp.dataora ASC
    ");
    // returns `null` on failure
    return $ret->fetch_all(MYSQLI_ASSOC);
}

function users()
{
    if (!isset($_SESSION["user"])) {
        return [];
    }
    $userId = $_SESSION["user"]["id"];
    // Open db connection
    $db = open_db();
    // On error return null
    if (!$db) {
        return [];
    }
    $ret = $db->query("SELECT id, nome FROM users WHERE id != '$userId'");
    return $ret->fetch_all(MYSQLI_ASSOC);
}

if ($_POST["action"] == "send") {
    echo json_encode(send($_POST["receiverId"], $_POST["message"]));

} else if ($_POST["action"] == "read") {
    echo json_encode(read($_POST["otherId"]));
} else if ($_POST["action"] == "users") {
    echo json_encode(users());
}
