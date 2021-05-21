<?php

$lng = "it";
if (array_key_exists("HTTP_ACCEPT_LANGUAGE", $_SERVER)) {
    $accept_lng = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
    if (in_array($accept_lng, ["it", "en", "de"])) {
        $lng = $accept_lng;
    }
}

function i18n($page)
{
    global $lng;
    $i18n = parse_ini_file("locales/$page.ini", true);
    return $i18n[$lng];
}
