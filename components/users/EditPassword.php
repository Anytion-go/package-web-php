<?php 
$title = import('wisit-router/title');

$EditPassword = function () use ($title) {
    $error = '';
    $db = new DB;
    $user = $db->CheckLogin();
    if (!$user) {
        header('Location: /login');
        die;
    }

    if (isset($_POST['submit'])) {
        if (empty($_POST['old']) || empty($_POST['password'])) {
            $error = '<div style="color:red;">ERROR EMTY</div>';
        } else {
            $result = $db->ChangePassword($_POST['old'], $_POST['password']);
            if($result == 400){
                $error = '<div style="color:lightgreen;">ERROR OLD PASSWORD</div>';
            }elseif ($result == 200) {
                $error = '<div style="color:lightgreen;">Edit successfuly</div>';
            } else {
                $error = '<div style="color:red;">ERROR edit failed</div>';
            }
        }
    }
    $title('Account | Edit');
    return <<<HTML
        <main class="mx-1 lg:mx-80">
            <div align="center">
                {$error}
                <div class="head">Change password</div>
                <form class="form" action="/{$user['name']}" method="post">
                    <input type="hidden" name="edit" value="password">
                    <div class="input-box">
                        <label class="label-dark" for="old password">old password</label>
                        <input class="input-dark" type="password" name="old" id="" required>
                    </div>
                    <div class="input-box">
                        <label class="label-dark" for="new password">new password</label>
                        <input class="input-dark" type="password" name="password" id="" required>
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

$export = $EditPassword;