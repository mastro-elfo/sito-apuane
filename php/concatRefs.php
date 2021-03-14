<?php function concatRefs($list, $href)
{
    return implode(", ", array_map(function ($item) use ($href) {
        $parts = explode("/", $item);
        if (count($parts) >= 2) {
            return "<a href='$href?id=$parts[0]'>$parts[1]</a>";
        }
        return "";
    }, $list));
}
