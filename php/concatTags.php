<?php
function concatTags($tags)
{
    return implode(", ", array_map(function ($tag) {
        $parts = explode("/", $tag);
        if (count($parts) >= 3) {
            return "<span class='tag' style='background-color:$parts[2];color:$parts[3]'>$parts[1]</span>";
        }
        return "";
    }, $tags));
}
