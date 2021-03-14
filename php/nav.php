<?php

$items = [
    [
        "href"  => "./",
        "match" => "~/(index\.php)?$~",
        "label" => "Home",
        "title" => "Home Page",
    ],
    // [
    //     "href"  => "vette.php",
    //     "label" => "Le vette",
    //     "title" => "Le vette delle Alpi Apuane",
    // ],
    // [
    //     "href"  => "percorsi.php",
    //     "label" => "I percorsi",
    //     "title" => "Percorsi del CAI",
    // ],
    // [
    //     "href"  => "rifugi.php",
    //     "label" => "I rifugi",
    //     "title" => "I Rifugi",
    // ],
    [
        "href"  => "luoghi.php",
        "label" => "Luoghi",
        "title" => "Luoghi sulle Alpi Apuane",
    ],
    [
        "href"  => "#",
        "label" => "Eventi",
        "title" => "Gli eventi sulle Alpi Apuane",
    ],
    [
        "href"  => "meteo.php",
        "label" => "Meteo",
        "title" => "Meteo locale",
    ],
    [
        "href"   => "accesso.php",
        "label"  => "Accedi",
        "title"  => "Accedi all&rsquo;area riservata",
        "access" => false,
    ],
    [
        "href"   => "profilo.php",
        "label"  => "Profilo",
        "title"  => "Il tuo profilo personale",
        "access" => true,
    ],
    [
        "href"   => "chat.php",
        "label"  => "Chat",
        "title"  => "Chatta con gli utenti",
        "access" => true,
    ],
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
