<?php

function open_db()
{
    // Load config from file
    $config = parse_ini_file("database.ini");
    // Create mysqli object
    $mysqli = new mysqli($config["host"], $config["username"], $config["password"], $config["database"]);
    /* check connection */
    if ($mysqli->connect_errno) {
        return null;
    }
    return $mysqli;
}
