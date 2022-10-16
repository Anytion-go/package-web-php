<?php
$title = import('wisit-router/title');
$getParams = import('wisit-router/getParams');
$EditPackage = import('./Cops/package/EditPackage');
$DeletePackage = import('./Cops/package/DeletePackage');
$CreateVersion = import('./Cops/version/CreateVersion');

$showVersion = function () use ($getParams) {
    $db = new DB;
    $package = $db->CheckPackage($getParams(1));
    $data = $db->MyVersion($package['name']);
    $content = '';
    $color = true;
    foreach ($data as $pk) {
        $color = !$color;
        $content .= <<<HTML
        <span>
           <a href="/package/{$package['name']}/{$pk['version']}">
            <div>
                <span class="key">{$pk['version']}</span><span class="value">{$pk['modif']}</span>
            </div>
        </a>
        </span>
        HTML;
    }
    return $content;
};

$export = function () use ($title, $getParams, $EditPackage, $DeletePackage, $CreateVersion, $showVersion) {
    if (isset($_POST['mod']) && $_POST['mod'] == 'edit') return $EditPackage();
    if (isset($_POST['mod']) && $_POST['mod'] == 'delete') return $DeletePackage();
    if (isset($_POST['version']) && $_POST['version'] == 'create') return $CreateVersion();

    $db = new DB;
    $menu = '';
    $user = $db->CheckLogin();
    $package = $db->CheckPackage($getParams(1));
    if (!$package) return '<main><div class="head">Not found package</div></main>';

    if ($user && $package && $user['name'] == $package['dev']) {
        $menu = <<<HTML
            <div>
                <form method="post" action="/package/{$package['name']}">
                    <div class="menu-block">
                        <button class="menu-items" name="mod" value="edit">Edit package</button>
                        <button class="menu-items" name="mod" value="delete">delete package</button>
                        <button class="menu-items" name="version" value="create">Create version</button>
                    </div>
                </form>
            </div>
        HTML;
    }

    $title('Pacakage | ' . $package['name']);
    $type = $package['type'] == 1 ? 'library' : 'template';
    ini_set('user_agent', '3lcieh2bon3032a');
    return <<<HTML
        <main class="mx-1 lg:mx-80">
        {$menu}
            <div>
                <div class=" package-block">
                    <div class="package-name">{$package['name']}</div>
                    
                    <span class="key">type</span><span class="value">{$type}</span>
                    <span class="key">last update</span><span class="value">{$package['modif']}</span>
                    <span class="key">date create</span><span class="value">{$package['date']}</span>
                    <span class="key">downloads</span><span class="value">{$package['download']}</span>
                    <div>
                        <a href="/{$package['dev']}">
                            <span class="key">developer</span><span class="value">{$package['dev']}</span>
                        </a>
                    </div>
                </div>
                <hr>
                <div>
                    <textarea class="text-discript" rows="5" disabled >{$package['descript']}</textarea>
                </div>
                <hr>
                <div class="text-center">
                    <a target="_blank" href="{$package['github']}">
                        <button class="btn-github"><img class="img-github" src="/public/github_icon.svg" alt="github logo">{$package['github']}</button>
                    </a>
                </div>
                <hr>
                <div class="text-center">
                    <div><a target="_blank" href="{$package['installer']}">
                        <button class="btn-github"><img class="img-github" src="/public/github_icon.svg" alt="github logo">{$package['installer']}</button>
                    </a></div>
                </div>
                <hr>
                <div class="head" id="version">others version</div>
                <hr>
                <div class="text-center m-3">
                    {$showVersion()}
                </div>
            </div>
        </main>
    HTML;
};
