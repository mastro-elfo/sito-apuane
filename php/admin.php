<?php

function isAdmin()
{
    return isset($_SESSION)
    && array_key_exists("user", $_SESSION)
    && array_key_exists("admin", $_SESSION["user"])
    && $_SESSION["user"]["admin"] == 1;
}
