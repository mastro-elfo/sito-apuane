<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once "../php/database.php";

function broken(){
  header("Content-Type: image/*");
  echo file_get_contents("../imgs/broken.png");
  exit;
}

$id = $_GET["id"];
$tableName = $_GET["table"];

if (!$id) {
    broken();
}

// Open db connection
$db = open_db();

// On error return null
if (!$db) {
    broken();
}

$ret = $db->query("
  SELECT image
  FROM `$tableName`
  WHERE id = '$id'
");

if(!$ret){
  broken();
}

$image = $ret->fetch_assoc();

if (!$image) {
    broken();
}

header("Content-Type: image/*");
echo $image["image"];
