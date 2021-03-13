<?php function concatRefs($list, $href)
{
    return implode(", ", array_map(function ($item) use ($href) {
        $parts = explode("/", $item);
        if (count($parts) > 1) {
            return "<a href='$href?id=$parts[1]'>$parts[0]</a>";
        }
        return "";
    }, $list));
}
