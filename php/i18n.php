<?php

function i18n($page)
{
    $lng  = "it";
    $i18n = parse_ini_file("locales/$page.ini", true);
    return $i18n[$lng];
}
