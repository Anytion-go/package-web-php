<?php
$title = import('wisit-router/title');
$getParams = import('wisit-router/getParams');

$export = function() use ($title, $getParams) {
    $db = new DB;
    $user = $db->CheckLogin();
    $package = $db->CheckPackage($getParams(1));
    if(!$package) return '<main><div>Not found package</div></main>';
    $version = $db->CheckVersion($package['name'], $getParams(2));
    if(!$version) return '<main><div>Not found package</div></main>';
    if($user['name'] != $package['dev']) return '<main><div>Not Found</div></main>';

    $error = '';
    if(isset($_POST['submit'])) {
        if(empty($_POST['password'])) {
            $error = '<div style="color:red;">ERROR EMTY</div>';
        } else {
            $result = $db->DeleteVersion($package['name'], $version['version'], $_POST['password']);
            if($result) {
                $error = '<div style="color:lightgreen;">Delete successfuly</div>';
            } else {
                $error = '<div style="color:red;">Delete failed</div>';
            }
        }
        
    }


    $title('Delete Package');
    return <<<HTML
        <main class="mx-1 lg:mx-80">
            <div align="center">
                <div class="head text-red-600">confirm delete 
                    <a class="hover:underline" href="/package/{$package['name']}/{$version['version']}">{$version['version']}</a> from 
                    <a class="hover:underline" href="/package/{$package['name']}">{$package['name']}</a>
                </div>
                <form class="form" method="post" action="/package/{$package['name']}/{$version['version']}">
                    {$error}
                    <input type="hidden" name="mod" value="delete">
                    <div class="mb-2">
                        <label class="bg-red-600 text-white p-1 block" for="password">password</label>
                        <input class="bg-white border border-red-600 p-1 w-full focus:outline-none" type="password" name="password" id="" required>
                    </div>
                    <button class="p-2 border-2 border-red-600 mt-10 rounded-sm hover:bg-red-600 hover:text-white" name="submit">comfirm</button>
                </form>
            </div>
        </main>
    HTML;
};