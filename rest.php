<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

require_once "oop/attribute.class.php";
require_once "oop/place.class.php";
require_once "oop/query.class.php";
require_once "oop/tag.class.php";

function get_places()
{
    $ret = (new Place)->query(
        (new Query)
            ->select(["id", "name", "uDateTime"])
            ->from("places")
            ->where("deleted = 0")
    );
    if ($ret) {
        $places = $ret->fetch_all(MYSQLI_ASSOC);
        $places = array_map(
            function ($p) {
                $p["href"] = "/rest.php?endpoint=place&id=$p[id]";
                return $p;
            },
            $places
        );
        return $places;
    }
    return [];
}

function get_place_by_id($id)
{
    $place = (new Place($id))->read([
        "id", "name", "title", "article", "description", "!isnull(image) as has_image", "uDateTime",
    ]);
    if ($place["has_image"]) {
        $place["src"] = "/php/img.php?id=$id";
    }
    $place["attributes"] = (new MyAttribute)->ofPlace($id);
    $place["tags"]       = (new Tag)->ofPlace($id);
    return $place;
}

// Check `endpoint`
if (array_key_exists("endpoint", $_GET)) {
    if ($_GET["endpoint"] == "places") {
        // Get list of all places
        echo json_encode([
            "error"   => false,
            "message" => "",
            "places"  => get_places(),
        ]);
    } elseif ($_GET["endpoint"] == "place") {
        // Get place detail
        // Check `id`
        if (array_key_exists("id", $_GET)) {
            // Get detail
            echo json_encode([
                "error"   => false,
                "message" => "",
                "place"   => get_place_by_id($_GET["id"]),
            ]);
        } else {
            // Id not given
            echo json_encode([
                "error"   => true,
                "message" => "Param id is required",
            ]);
        }
    } else {
        // Unknown endpoint
        echo json_encode([
            "error"   => true,
            "message" => "Unknown endpoint: $_GET[endpoint]",
        ]);
    }
} else {
    // List all endpoints
    echo json_encode([
        "error"     => false,
        "message"   => "",
        "endpoints" => [
            [
                "endpoint" => "places",
            ],
            [
                "endpoint" => "place",
                "params"   => [
                    "id",
                ],
            ],
        ],
    ]);
}
