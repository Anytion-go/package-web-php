<?php
$title = import('wisit-router/title');
$getParams = import('wisit-router/getParams');

$export = function () use ($title, $getParams) {
    $db = new DB;
    $user = $db->CheckLogin();
    $package = $db->CheckPackage($getParams(1));
    $error = '';

    $v = '';
    $descript = '';
    $github = '';
    $installer = '';

    if (isset($_POST['submit'])) {
        $v = $_POST['v'];
        $descript = $_POST['descript'];
        $github = $_POST['github'];
        $installer = $_POST['installer'];
        if (
            empty($_POST['v']) ||
            empty($_POST['descript']) ||
            empty($_POST['github']) ||
            empty($_POST['installer'])
        ) {
            $error = '<div style="color: red;">ERROR EMTY</div>';
        } else {
            $result = $db->CreateVersion($package['name'], $_POST['v'], $_POST['descript'], $_POST['github'], $_POST['installer']);
            
            if ($result === 200) {
                $error = '<div style="color:red;">ERROR  name has already used</div>';
            } elseif ($result === 400) {
                $error = '<div style="color:green;">Create successfuly </div>';
            } elseif ($result === 300) {
                $error = '<div style="color:red;">name ERROR</div>';
            }
        }
    }

    $title('Create Version');
    return <<<HTML
        <main class="mx-1 lg:mx-80">
            <div align="center">
                <div class="head">
                    Create version for <a class="hover:underline" href="/package/{$package['name']}">{$package['name']}</a>
                </div>
                <form class="form" method="post" action="/package/{$package['name']}">
                    <input type="hidden" name="version" value="create">
                    {$error}
                    <div class="input-box">
                        <label class="label-dark" for="version">name version ( only number and - ) Ex. 1-0-0</label>
                        <input class="input-dark" type="text" name="v" value="{$v}" required>
                    </div>
                    <div>
                        <div class="label-dark">Description</div>
                        <textarea class="textarea-dark" name="descript" id="" rows="5" required>{$descript}</textarea>
                    </div>
                    <div class="input-box">
                        <label class="label-dark" for="github">Github</label>
                        <input class="input-dark" type="text" name="github" value="{$github}" required>
                    </div>
                    <div class="input-box">
                        <label class="label-dark" for="installer">Url branch</label>
                        <input class="input-dark" type="text" name="installer" value="{$installer}" required>
                    </div>
                    <button class="btn-dark" name="submit">Done</button>
                </form>
            </div>
        </main>
    HTML;
};
