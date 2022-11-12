<?php
$title = import('wisit-router/title');
$getParams = import('wisit-router/getParams');

$export = function () use ($title, $getParams) {
    $db = new DB;
    $user = $db->CheckLogin();
    $package = $db->CheckPackage($getParams(1));
    if(!$package) return '<main><div>Not found package</div></main>';
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
            $result = $db->EditPackage(
                $package['name'],
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
        <main class="mx-80">
            <div align="center">
                <div class="head">Edit <a class="hover:underline" href="/package/{$package['name']}">{$package['name']}</a></div>
                <div>
                    {$error}
                    <form class="form" action="/package/{$package['name']}" method="post">
                        <input type="hidden" name="mod" value="edit">
                        <div class="input-box">
                            <label class="label-dark" for="description">description</label>
                            <textarea class="textarea-dark" name="descript" id="" rows="5" required>{$descript}</textarea>
                        </div>
                        <div class="input-box">
                            <label class="label-dark" for="installer">Url branch</label>
                            <input class="input-dark" type="text" name="installer" value="$installer" id="" required>
                        </div>
                        <button class="btn" name="submit">Done</button>
                    </form>
                </div>
            </div>
        </main>
    HTML;
};
