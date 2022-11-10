<?php
$title = import('wisit-router/title');
$getParams = import('wisit-router/getParams');
$EditVersion = import('./Cops/version/EditVersion');
$DeleteVersion = import('./Cops/version/DeleteVersion');

$export = function () use ($title, $getParams, $EditVersion, $DeleteVersion) {
    if (isset($_POST['mod']) && $_POST['mod'] == 'delete') return $DeleteVersion();
    if (isset($_POST['mod']) && $_POST['mod'] == 'edit') return $EditVersion();

    $db = new DB;
    $user = $db->CheckLogin();
    $package = $db->CheckPackage($getParams(1));
    if (!$package) return '<main><div>Not found version</div></main>';
    $version = $db->CheckVersion($package['name'], $getParams(2));
    if (!$version) return '<main><div>Not found version</div></main>';
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
    $type = $version['type'] == 1 ? 'module' : 'template';
    $checkType = $version['type'] == 1 ? 'bg-green-200' : 'bg-lime-100';
    ini_set('user_agent', '3lcieh2bon3032a');
    return <<<HTML
        <main class="mx-1 lg:mx-80">

            {$menu}

        <div>
                <div class="package-block">
                    <div class="package-name">
                        <a class="hover:underline" href="/package/{$package['name']}">{$package['name']} </a>
                        <span class=" text-rose-600 ">@{$version['version']}</span>
                    </div>

                    <span class="key">type</span><span class="value">{$type}</span>
                    <span class="key">last update</span><span class="value">{$version['modif']}</span>
                    <span class="key">date create</span><span class="value">{$version['date']}</span>
                    <span class="key">downloads</span><span class="value">{$package['download']}</span>
                    
                    <div>
                        <a href="/{$package['dev']}">
                            <span class="key">developer</span><span class="value">{$package['dev']}</span>
                        </a>
                    </div>
                </div>
                    
                <hr>
                <div>
                    <textarea class="text-discript" disabled rows="5">{$version['descript']}</textarea>
                </div>
                <hr>
                <div class="text-center">
                  <a target="_blank" href="{$version['github']}"><button class="btn-github"><img class="img-github" src="/public/github_icon.svg" alt="github logo">{$version['github']}</button></a>
                </div>
                <hr>
                <div class="text-center">
                    <div><a target="_blank" href="{$version['installer']}"><button class="btn-github"><img class="img-github" src="/public/github_icon.svg" alt="github logo">{$version['installer']}</button></a></div>
                </div>
                <div style="margin-bottom: 100px;"></div>
            </div>
        </main>
    HTML;
};
