<?php
$title = import('wisit-router/title');
$getParams = import('wisit-router/getParams');

$export = function () use ($title, $getParams) {
    $db = new DB;
    $user = $db->CheckLogin();
    $package = $db->CheckPackage($getParams(1));
    if(!$package) return '<main><div>Not found package</div></main>';
    $version = $db->CheckVersion($package['name'], $getParams(2));
    if(!$version) return '<main><div>Not found package</div></main>';
    
    if($user['name'] != $package['dev']) return '<main><div>Not Found</div></main>';
    $error = '';

    $descript = $package['descript'];
    $installer = $package['installer'];

    if (isset($_POST['submit'])) {
        $descript = $_POST['descript'];
        $installer = $_POST['installer'];
        if (
            empty($_POST['descript']) ||
            empty($_POST['installer'])
        ) {
            $error = '<div style="color:red;">ERROR EMTY</div>';
        } else {
            $result = $db->EditVersion(
                $package['name'],
                $version['version'],
                $_POST['descript'],
                $_POST['installer']
            );

            if ($result) {
                $error = '<div style="color:green;">Edit successfuly</div>';
            } else {
                $error = '<div style="color:red;">Edit failed</div>';
            }
        }
    }



    $title('Edit | ' . $package['name']);
    return <<<HTML
        <main class="mx-1 lg:mx-80">
            <div align="center">
                <div class="head">Edit <a 
                    class="hover:underline"
                    href="/package/{$package['name']}/{$version['version']}"
                    >{$package['name']}@{$version['version']}</a></div>
                <div>
                    {$error}
                    <form class="form" action="/package/{$package['name']}/{$version['version']}" method="post">
                        <input type="hidden" name="mod" value="edit" required>
                        <div class="mb-2">
                            <label class="label-dark" for="description">description</label>
                            <textarea class="textarea-dark" name="descript" id="" rows="5" required>{$descript}</textarea>
                        </div>
                        <div class="mb-2">
                            <label class="label-dark" for="installer">Url branch </label>
                            <input class="input-dark" type="text" name="installer" value="$installer" id="" required>
                        </div>
                        <button class="btn-dark" name="submit">Done</button>
                    </form>
                </div>
            </div>
        </main>
    HTML;
};
