<?php
return function () {
    $link = "$_SERVER[REQUEST_URI]";
    $path = "/";
    $str_len = strlen($link);
    for ($i = 1; $i < $str_len; $i++) {
        if ($link[$i] == '?') {
            break;
        } else {
            $path = $path . $link[$i];
        }
    }
    return $path;
};