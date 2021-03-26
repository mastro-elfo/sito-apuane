<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once "../oop/place.class.php";

header("Content-Type: image/*");

$id = $_GET["id"];
if (!$id) {
    header('Content-Disposition: filename="notfound.png"');
    echo file_get_contents("../imgs/broken.png");
    exit;
}
$cPlace = new Place($id);
$place  = $cPlace->read();
$image  = $cPlace->image();
if (!$image) {
    broken();
}

header('Content-Disposition: filename="' . $place["name"] . '.jpg"');
echo $image;
