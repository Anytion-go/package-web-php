<?php 
$title = import('wisit-router/title');
$YouAreLogined = import('./components/YouAreLogined');

$Register = function () use ($title, $YouAreLogined) {
    if (isset($_COOKIE['token1'])) return $YouAreLogined();

    $error = '';
    $name = '';
    $username = '';
    $descript = '';
    $question = '';
    $answer = '';

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $username = $_POST['username'];
        $descript = $_POST['descript'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];

        $db = new DB;
        $result = $db->Register(
            $_POST['name'],
            $_POST['username'],
            $_POST['password'],
            $_POST['descript'],
            $_POST['question'],
            $_POST['answer'],
        );
        if($result === 100){
            $error = '<div style="color:red;">ERROR EMTY</div>';
        } elseif($result === 200) {
            $error = '<div style="color:red;">ERROR Username or name has already used</div>';
        } elseif($result === 400) {
            $error = '<div style="color:green;">Register successfuly please login</div>';
        } elseif($result === 300){
            $error = '<div style="color:red;">name or username ERROR</div>';
        }
    }
    $title('Register');
    return <<<HTML
        <main class="mx-1 lg:mx-80">
            <div align="center">
                <div class="head">Register</div>
                {$error}
                <form class="form" action="/register" method="post">
                    <div class="input-box">
                        <label class="label-dark" for="name">Name (lowercase)</label>
                        <input class="input-dark" type="text" maxlength="50" name="name" value="{$name}" id="" required>
                    </div>
                    <div class="input-box">
                        <label class="label-dark" for="description">description</label>
                        <textarea class="textarea-dark" name="descript" maxlength="250" id="" cols="30" rows="5" required>{$descript}</textarea>
                    </div>
                    <div class="input-box">
                        <label class="label-dark" for="username">username</label>
                        <input class="input-dark" type="text" name="username"  maxlength="50" value="{$username}" required>
                    </div>
                    <div class="input-box">
                        <label class="label-dark" for="password">password</label>
                        <input class="input-dark" type="password"  maxlength="50" name="password" id="" required>
                    </div>
                    <div class="input-box">
                        <label class="label-dark" for="question">question</label>
                        <input class="input-dark" type="text" name="question"  maxlength="50" value="{$descript}" id="" required>
                    </div>
                    <div class="input-box">
                        <label class="label-dark" for="answer">answer</label>
                        <input class="input-dark" type="text" name="answer"  maxlength="50" value="{$answer}" id="" required>
                    </div>
                    <div class="input-box text-right">
                        <input class="w-4 h-4 bg-black checked:accent-black" type="checkbox" name="accept" id="" required>Accept all
                    </div>
                    <button
                        type="submit"
                        class="btn-dark"
                        name="submit"
                    >Register</button>
                </form>
                <div align="right"><a class=" p-1 inline-block hover:underline" href="/login">Login</a></div>
            </div>
        </main>
    HTML;
};

$export = $Register;