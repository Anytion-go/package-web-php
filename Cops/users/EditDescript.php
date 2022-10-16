<?php
$title = import('wisit-router/title');

$EditDescript = function () use ($title) {
    $error = '';
    $db = new DB;
    $user = $db->CheckLogin();
    if (!$user) {
        header('Location: /login');
        die;
    }
    $descript = $user['descript'];

    if (isset($_POST['submit'])) {
        $descript = $_POST['descript'];

        $result = $db->EditDescript($descript);
        if ($result) {
            $error = '<div style="color:lightgreen;">Edit successfuly</div>';
        } else {
            $error = '<div style="color:red;">ERROR edit failed</div>';
        }
    }
    $title('Account | Edit');
    return <<<HTML
        <main class="mx-1 lg:mx-80">
            <div align="center">
                {$error}
                <div class="head">Edit profile description</div>
                <form class="form" action="/{$user['name']}" method="post">
                    <input type="hidden" name="edit" value="descript">
                    <div>
                        <label class="label-dark" for="description">description</label>
                        <textarea class="textarea-dark" name="descript" id="" cols="30" rows="5" required>{$descript}</textarea>
                    </div>
                    <button
                        type="submit"
                        class="btn-dark"
                        name="submit"
                    >Done</button>
                </form>
            </div>
        </main>
    HTML;
};

$export = $EditDescript;