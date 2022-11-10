<?php
$title = import('wisit-router/title');

$Login = function () use ($title) {
    $title('Login');

    $error = '';
    $db = new DB;

    if (isset($_GET['logout'])) {
       $db->Logout();
    }

    if (isset($_POST['submit'])) {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            $error = '<div style="color:red;">ERROR EMTY</div>';
        } else {
            $result = $db->Login($_POST['username'], $_POST['password']);
            if ($result) {
                header('Location: /login', true);
                exit;
            } else {
                $error = '<div style="color:red;">Login ERROR</div>';
            }
        }
    }

    if (isset($_COOKIE['token1'])) return '<main><div align="center">You are now Logined</div></main>';

    return <<<HTML
        <main class="mx-1 lg:mx-80">
            <div align="center">
                <div class="head">Login</div>
                {$error}
                <form class="form" action="/login" method="post">
                    <div class="mb-2">
                        <label class="label-dark" for="username">username</label>
                        <input class="input-dark" type="text" name="username" id="">
                    </div>
                    <div class="mb-2">
                        <label class="label-dark" for="password">password</label>
                        <input class="input-dark" type="password" name="password" id="">
                    </div>
                    <button
                        type="submit"
                        class="btn-dark"
                        name="submit"
                    >Login</button>
                </form>
                <div align="right"><a class=" hover:underline inline-block " href="/register">Register</a></div>
            </div>
        </main>
    HTML;
};

$export = $Login;
