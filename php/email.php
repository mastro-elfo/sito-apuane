<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$headers = "From: noreply@apuane.it\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html;charset=utf-8\r\n";

ob_start();
include("email.html");
$codEmail = ob_get_clean();

mail("francesco.209@gmail.com", "Benvenuto sul sito", $codEmail, $headers);

?>
