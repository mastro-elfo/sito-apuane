<?php

function formatParagraphs($paragraphs)
{
    return implode("", array_map(function ($p) {
        $par = $p;
        $par = preg_replace("/\*(.+?)\*/", "<strong>$1</strong>", $par);
        return "<p>$par</p>";
    }, explode("\n", $paragraphs)));
}
