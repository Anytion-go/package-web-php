<?php
$title = import('wisit-router/title');
$getParams = import('wisit-router/getParams');
$EditVersion = import('./components/version/EditVersion');
$DeleteVersion = import('./components/version/DeleteVersion');

$NotFoundPage = import('./pages/_error');

$export = function () use ($title, $getParams, $EditVersion, $DeleteVersion, $NotFoundPage) {
    if (isset($_POST['mod']) && $_POST['mod'] == 'delete') return $DeleteVersion();
    if (isset($_POST['mod']) && $_POST['mod'] == 'edit') return $EditVersion();

    $db = new DB;
    $user = $db->CheckLogin();
    $package = $db->CheckPackage($getParams(1));
    if (!$package) return $NotFoundPage();
    $version = $db->CheckVersion($package['name'], $getParams(2));
    if (!$version) return $NotFoundPage();
    $menu = '';

    if ($package && $user && $user['name'] == $package['dev'] && $package['name'] == $version['package_name']) {
        $menu = <<<HTML
            <div>
                <form method="post" action="/package/{$package['name']}/{$version['version']}">
                    <div class="menu-block">
                        <button class="menu-items" name="mod" value="edit">Edit</button>
                        <button class="menu-items" name="mod" value="delete">delete</button>
                    </div>
                </form>
            </div>
        HTML;
    }

    $title($package['name'] . ' @ ' . $version['version']);
    $type = $version['type'] == 1 ? 'library' : 'template';
    ini_set('user_agent', '3lcieh2bon3032a');
    return <<<HTML
        <main class="mx-1 lg:mx-80">

            {$menu}

        <div>
                <div class="package-block">
                    <div class="package-name">
                        <a class="hover:underline" href="/package/{$package['name']}">{$package['name']}</a><span class=" text-rose-600 ">@{$version['version']}</span>
                    </div>

                    <div class="card-box">
                        <span class="card-key">type</span><span class="card-value">{$type}</span>
                    </div>
                    <div class="card-box">
                        <span class="card-key">last update</span><span class="card-value">{$version['modif']}</span>
                    </div>
                    <div class="card-box">
                        <span class="card-key">date create</span><span class="card-value">{$version['date']}</span>
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
                    <textarea class="card-area" disabled rows="5">{$version['descript']}</textarea>
                </div>
                <div class="card-form">

                    <div class="text-center">
                        <a target="_blank" href="{$version['github']}"><button class="btn-github"><img class="img-github" src="/public/github_icon.svg" alt="github logo">Source code</button></a>
                    </div>
                    <hr>
                    <div class="text-center">
                        <div><a target="_blank" href="{$version['installer']}"><button class="btn-github"><img class="img-github" src="/public/github_icon.svg" alt="github logo">{$version['installer']}</button></a></div>
                    </div>
                </div>                
                    <div style="margin-bottom: 100px;"></div>
            </div>
        </main>
    HTML;
};
