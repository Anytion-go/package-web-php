<?php
return function ($path, $callBackFunc) {
    if ($path == '*') return $callBackFunc;
    $getPath = require('./modules/wisit-router/getPath.php');
    $getPath = explode('/', $getPath());
    $Route_path = explode('/', $path);

    if (sizeof($getPath) != sizeof($Route_path)) return;
    for ($i = 0; $i < sizeof($Route_path); $i++) {
        if ($getPath[$i] != $Route_path[$i] && $Route_path[$i] != ':') return;
    }
    return $callBackFunc;
};
