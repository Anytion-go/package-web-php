<?php
$title = import("wisit-router/title");
$export = function () use($title) {
    $title("Not found");
    return <<<HTML
    <main class="mx-1 lg:mx-80">
        <h1 class="border border-rose-500 p-2 rounded my-2 text-rose-500 text-lg text-center">Not found this page</h1>
        <div class="text-center">
            <a href="/">
                <button class="border border-slate-500 p-2 rounded hover:bg-slate-500 text-slate-800 hover:text-white duration-300">Go to homepage</button>
            </a>
        </div>
    </main>
    HTML;
};
