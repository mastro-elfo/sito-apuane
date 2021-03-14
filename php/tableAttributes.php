<?php

function tableAttributes($attributes)
{
    $table = "";
    $table .= "<table>";
    foreach ($attributes as $attribute) {
        $parts = explode("/", $attribute);
        $table .= "<tr>";
        $table .= "<td>";
        $table .= $parts[0];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $parts[1];
        $table .= "</td>";
        $table .= "</tr>";
    }
    $table .= "</table>";
    return $table;
}
