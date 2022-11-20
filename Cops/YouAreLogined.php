<?php
$title = import('wisit-router/title');
$export = function () use ($title) {
    $title("Logined");
    
    return <<<HTML
    <main class="mx-1 lg:mx-80">
        <h1 class="head-outline">You are now Logined</h1>
    </main>
    HTML;
};