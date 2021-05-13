<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once "oop/place.class.php";

function broken()
{
    // header("Content-Type: image/*");
    // header('Content-Disposition: filename="notfound.png"');
    // echo file_get_contents("../imgs/broken.png");
    header('Content-Disposition: filename="notfound.svg"');
    header("Content-Type: image/svg+xml");
    echo file_get_contents("imgs/notfound.svg");
}

$id = $_GET["id"];
if (!$id) {
    broken();
    exit;
}
$cPlace = new Place($id);
$place  = $cPlace->read();
$image  = $cPlace->image();
if (!$image) {
    broken();
    exit;
}

header("Content-Type: image/*");
header('Content-Disposition: filename="' . $place["name"] . '.jpg"');
echo $image;
