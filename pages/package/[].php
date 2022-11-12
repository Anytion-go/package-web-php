<?php
$title = import('wisit-router/title');
$getParams = import('wisit-router/getParams');
$EditPackage = import('./Cops/package/EditPackage');
$DeletePackage = import('./Cops/package/DeletePackage');
$CreateVersion = import('./Cops/version/CreateVersion');

$NotFoundPage = import('./pages/_error');

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
            <div class="card-box">
                <span class="card-key">{$pk['version']}</span><span class="card-value">{$pk['modif']}</span>
            </div>
        </a>
        </span>
        HTML;
    }
    if(empty($content)) $content = <<<HTML
    <div class="head-outline">No others version</div>
    HTML;
    return $content;
};

$export = function () use ($title, $getParams,$NotFoundPage, $EditPackage, $DeletePackage, $CreateVersion, $showVersion) {
    if (isset($_POST['mod']) && $_POST['mod'] == 'edit') return $EditPackage();
    if (isset($_POST['mod']) && $_POST['mod'] == 'delete') return $DeletePackage();
    if (isset($_POST['version']) && $_POST['version'] == 'create') return $CreateVersion();

    $db = new DB;
    $menu = '';
    $user = $db->CheckLogin();
    $package = $db->CheckPackage($getParams(1));
    
    if (!$package) return $NotFoundPage();

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
                    <div class="card-box">
                        <span class="card-key">type</span><span class="card-value">{$type}</span>
                    </div>
                    <div class="card-box">
                        <span class="card-key">last update</span><span class="card-value">{$package['modif']}</span>
                    </div>
                    <div class="card-box">
                        <span class="card-key">date create</span><span class="card-value">{$package['date']}</span>
                    </div>
                    <div class="card-box">
                        <span class="card-key">downloads</span><span class="card-value">{$package['download']}</span>
                    </div>
                    <div class="card-box">
                        <a href="/{$package['dev']}">
                            <span class="card-key hover:bg-black">developer</span><span class="card-value">{$package['dev']}</span>
                        </a>
                    </div>
                </div>
                <hr>
                <div>
                    <textarea class="card-area" rows="5" disabled >{$package['descript']}</textarea>
                </div>

                <div class="card-form">

                    <div class="text-center">
                        <a target="_blank" href="{$package['github']}">
                            <button class="btn-github"><img class="img-github" src="/public/github_icon.svg" alt="github logo">Soure code</button>
                        </a>
                    </div>
                    <hr>
                    <div class="text-center">
                        <div><a target="_blank" href="{$package['installer']}">
                            <button class="btn-github"><img class="img-github" src="/public/github_icon.svg" alt="github logo">{$package['installer']}</button>
                        </a></div>
                    </div>
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
