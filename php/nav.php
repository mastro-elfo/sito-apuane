<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "php/i18n.php";
$_i18n = i18n("nav");

$items = [
    [
        "href"  => "./",
        "match" => "~/(index\.php)?$~",
        "label" => $_i18n["home"],
        "title" => $_i18n["home_title"],
    ],
    [
        "href"  => "luoghi.php",
        "label" => $_i18n["places"],
        "title" => $_i18n["places_title"],
    ],
    // [
    //     "href"  => "#",
    //     "label" => "Eventi",
    //     "title" => "Gli eventi sulle Alpi Apuane",
    // ],
    [
        "href"  => "mappa.php",
        "label" => $_i18n["map"],
        "title" => $_i18n["map_title"],
    ],
    [
        "href"   => "login.php",
        "label"  => $_i18n["login"],
        "title"  => $_i18n["login_title"],
        "access" => false,
    ],
    [
        "href"   => "profilo.php",
        "label"  => $_i18n["profile"],
        "title"  => $_i18n["profile_title"],
        "access" => true,
    ],
    [
        "href"   => "bacheca.php",
        "label"  => $_i18n["board"],
        "title"  => $_i18n["board_title"],
        "access" => true,
    ]
];
?>

<nav>
  <ul>
    <?php
foreach ($items as $item) {
    // La pagina e' riservata agli utenti iscritti
    if (array_key_exists("access", $item) && $item["access"] && !isset($_SESSION["user"])) {
        continue;
    }

    // La pagina e' visibile solo se l'utente non ha effettuato l'accesso
    if (array_key_exists("access", $item) && $item["access"] === false && isset($_SESSION["user"])) {
        continue;
    }

    // Try to match the "match" attribute
    if (array_key_exists("match", $item)) {
        if (isset($item["match"])
            && preg_match($item["match"], $_SERVER["REQUEST_URI"])) {echo "<li class='selected'><a href='#' title='$item[title]'>$item[label]</a></li>";} else {
            echo "<li><a href='$item[href]' title='$item[title]'>$item[label]</a></li>";
        }
    }
    // Or try to match the "href" attribute
    else if (preg_match("~" . $item["href"] . "$~", $_SERVER["REQUEST_URI"])) {
        echo "<li class='selected'><a href='#' title='$item[title]'>$item[label]</a></li>";
    }
    // Otherwise
    else {
        echo "<li><a href='$item[href]' title='$item[title]'>$item[label]</a></li>";
    }
}
?>
  </ul>
</nav>
