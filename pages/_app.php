<?php
ob_start();
session_start();
import('dotenv')->config();

$Header = import('./Cops/Header');
$Footer = import('./Cops/Footer');
$getParams = import('wisit-router/getParams');
import('./Cops/DB');

$export = function ($Component) use ($Header, $Footer, $getParams) {
  if($getParams(0) == 'install') return $Component();
    $GLOBALS['title'] = 'title';

    $content = $Component();
    $header = $Header();
    $footer = $Footer();

    return <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="shortcut icon" href="/public/logo.png" type="image/x-icon">
      <title>{$GLOBALS['title']}</title>
      <link rel="stylesheet" href="/styles/output.css">
      <link rel="stylesheet" href="/styles/style.css">
    </head>
    <body>
      {$header}
      {$content}
      {$footer}
      <script src="/styles/script.js"></script>
    </body>
    </html>
    HTML;
};
?>
