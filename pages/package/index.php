<?php
$title = import('wisit-router/title');

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
            $content .= '<div class="head bg-white">Not found any package</div>';
        }
    } else {
        $data = $db->AllPackage();
    }
    foreach ($data as $pac) {
        $type = $pac['type'] == 1 ? 'library' : 'template';
        $content .= <<<HTML
        <div class=" border-b border-gray-200 p-3">
            <div class="hover:underline text-2xl "><a href="/package/{$pac['name']}">{$pac['name']}</a></div>
            <div class="m-2 text-sm">

                <div class="inline-block my-3">
                    <span class="bg-black border border-black text-white p-1">type</span><span class="bg-white text-black p-1 border border-black mr-1">{$type}</span>
                </div>
                <div class="inline-block my-3">
                    <span class="bg-black border border-black text-white p-1">last update</span><span class="bg-white text-black p-1 border border-black mr-1">{$pac['modif']}</span>
                </div>
                <div class="inline-block my-3">
                    <span class="bg-black border border-black text-white p-1">downloads</span><span class="bg-white text-black p-1 border border-black mr-1">{$pac['download']}</span>
                </div>
                <div>
                    <textarea class=" w-full resize-none text-md bg-slate-100 p-1 rounded" rows="3" disabled>{$pac['descript']}</textarea>
                </div>
                <div class="my-3">
                    <a href="/{$pac['dev']}">
                        <span class="bg-black border border-black text-white p-1">Developer</span><span class="bg-white text-black p-1 border border-black mr-1">{$pac['dev']}</span>
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
            <div class="flex text-center my-1">
                <div onclick="setMode('library')" id="library" class="package-unactive">Library</div>
                <div onclick="setMode('template')" id="template" class="package-unactive">Template</div>
            </div>
            <div>
                <div class="m-3 text-center sm:hidden">
                    <form action="/package/">
                        <input class="input-search" type="search" name="search" id="" value="{$ser}">
                        <input type="hidden" name="mode" value="{$mode}" >
                        <button class="border border-black bg-black text-white p-1 text-lg rounded">search</button>
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
