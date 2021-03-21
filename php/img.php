<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once "../oop/place.class.php";

header("Content-Type: image/*");

$id = $_GET["id"];
if (!$id) {
    echo file_get_contents("../imgs/broken.png");
    exit;
}
$cPlace = new Place($id);
$image = $cPlace->image();
if (!$image) {
    broken();
}
echo $image;
