<?php
$title = import('wisit-router/title');

// for make "package-active" class working
// if have no $void this class is not working
$void = <<<HTML
    <div class="package-active"></div>
HTML;
// this is notihing


$showPackage = function () {
    $db = new DB;
    $content = '';
    if (isset($_GET['search']) && isset($_GET['mode'])) {
        if (strlen($_GET['search']) < 1 && $_GET['mode'] == 'all') {
            header("Location: /package/");
            die;
        }
        $data = $db->SearchPackage($_GET['search'], $_GET['mode']);
        if (empty($data)) {
            $content .= '<div class="head-outline">Not found any package</div>';
        }
    } else {
        $data = $db->AllPackage();
    }
    foreach ($data as $pac) {
        $type = $pac['type'] == 1 ? 'library' : 'template';
        $content .= <<<HTML
        <div class="card-form">
            <div class="card-name"><a href="/package/{$pac['name']}">{$pac['name']}</a></div>
            <div class="m-2 text-sm">

                <div class="card-box">
                    <span class="card-key">type</span><span class="card-value">{$type}</span>
                </div>
                <div class="card-box">
                    <span class="card-key">last update</span><span class="card-value">{$pac['modif']}</span>
                </div>
                <div class="card-box">
                    <span class="card-key">downloads</span><span class="card-value">{$pac['download']}</span>
                </div>
                <div>
                    <textarea class="card-area" rows="3" disabled>{$pac['descript']}</textarea>
                </div>
                <div class="my-3">
                    <a href="/{$pac['dev']}">
                        <span class="card-key hover:bg-black">Developer</span><span class="card-value">{$pac['dev']}</span>
                    </a>
                </div>

            </div>
        </div>
        HTML;
    }
    return $content;
};

$export = function () use ($title, $showPackage) {
    $title('Package');
    $ser = $_GET['search'] ?? '';
    $mode = $_GET['mode'] ?? 'all';
    $titleMode = "Packages";
    if(isset($_GET['mode'])) {
        if($_GET['mode'] == 'library') {
            $titleMode = "Library";
        } else if($_GET['mode'] == 'template'){
            $titleMode = 'Template';
        }
    }
    return <<<HTML
        <main class="mx-1 lg:mx-80">
            <div class="flex text-center my-3">
                <div onclick="setMode('library')" id="library" class="package-unactive rounded-l">Library</div>
                <div onclick="setMode('template')" id="template" class="package-unactive rounded-r">Template</div>
            </div>
            <div>
                <div class="m-3 text-center sm:hidden">
                    <form action="/package/">
                        <input class="input-search border border-black border-opacity-80" type="search" name="search" id="" value="{$ser}">
                        <input type="hidden" name="mode" value="{$mode}" >
                        <button class="border border-black bg-black bg-opacity-80 text-white p-1 text-lg rounded">search</button>
                    </form>
                </div>
                <h1 class="head"><a href="/package/">{$titleMode}</a></h1>
                <div>

                    {$showPackage()}

                </div>
                <div class="h-10"></div>
            </div>
        </main>
    HTML;
};
