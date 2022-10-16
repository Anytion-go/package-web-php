<?php
$getParams = import('wisit-router/getParams');
$export = function () use ($getParams) {
    ini_set('user_agent', '3lcieh2bon3032a');

    $db = new DB;
    $content = '';
    $package = $db->CheckPackage($getParams(), 2);
    if ($package) {
        $db->DownloadCount($package['name']);
        $content = $package['installer'];
    }
    return $content;
};
