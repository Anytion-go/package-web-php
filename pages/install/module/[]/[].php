<?php 
$getParams = import('wisit-router/getParams');
$export = function () use ($getParams) {
    ini_set('user_agent', '3lcieh2bon3032a');

    $db = new DB;
    $content = '';
    $package = $db->CheckVersion($getParams(2), $getParams(), 1);
    if($package) {
        $db->DownloadCount($package['package_name']);
        $content = $package['installer'];
    } 
    return $content;
};