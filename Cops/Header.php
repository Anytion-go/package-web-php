<?php

$Header = function () {
    $login = '';
    if (isset($_COOKIE['token1']) && isset($_COOKIE['token2'])) {
        $db = new DB;
        $name = $db->CheckLogin();
        if ($name != false) {
            $login = '<div class="sub-menu"><a href="/' . $name['name'] . '">' . $name['name'] . '</a></div>' .
                '<div  class="sub-menu"><a href="/myfollow">My Follow</a></div>
                <div  class="sub-menu"><a href="/?feed">Feed</a></div>
                <div  class="sub-menu"><a href="/login?logout">Logout</a></div>
                ';
        }
    } else {
        $login = '<div class="sub-menu"><a href="/login">Login</a></div>';
    }
    $ser = $_GET['search'] ?? '';
    $mode = $_GET['mode'] ?? "all";
    return <<<HTML
        <nav class=" bg-white text-black text-center py-2 px-2 sm:px-10 sm:flex sm:justify-center border-b-2">
            <div class=" p-0 w-8 inline-block mr-2">
                <a class="hidden sm:inline" href="/"><img src="/public/logo.png" alt="Logo brand">LTP</a>
                <span class="sm:hidden" href="#" onclick="switchShow()"><img src="/public/logo.png" alt="Logo brand">LTP</span>
            </div>
            <div id="menu" class="menu hidden sm:flex">
                <div class="sm:hidden sub-menu"><a href="/">Home</a></div>
                <div class="sub-menu"><a href="/docs">Docs</a></div>
                <div class="sub-menu"><a href="/package/">Packages</a></div>
                <div class="sub-menu"><a href="/accounts">Accounts</a></div>
                {$login}
                <div class="mx-10">
                    <form id="form-search" action="/package/">
                        <input class="input-search" id="search" type="search" name="search" placeholder="search package ctrl+k" value="{$ser}">
                        <input id="mode" type="hidden" name="mode" value="{$mode}">
                        <button class="m-1">search</button>
                    </form>
                </div>
            </div>
        </nav>
    HTML;
};

$export = $Header;
