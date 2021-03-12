<?php

require_once "../ajax/database.php";

$peakId = $_GET["id"];
$tableName = $_GET["table"];

if (!$peakId) {
    echo file_get_contents("../imgs/broken.png");
    exit;
}

// Open db connection
$db = open_db();
// On error return null
if (!$db) {
    echo file_get_contents("../imgs/broken.png");
    exit;
}

$ret = $db->query("
  SELECT image
  FROM `$tableName`
  WHERE id = '$peakId'
");
$image = $ret->fetch_assoc();
if (!$image) {
    echo file_get_contents("../imgs/broken.png");
    exit;
}

echo $image["image"];
