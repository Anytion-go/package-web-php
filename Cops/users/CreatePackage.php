<?php
$title = import('wisit-router/title');

$export = function () use ($title) {
    $db = new DB;
    $user = $db->CheckLogin();
    $error = '';

    $name = '';
    $descript = '';
    $github = '';
    $installer = '';
    $type = '';

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $descript = $_POST['descript'];
        $github = $_POST['github'];
        $installer = $_POST['installer'];
        $type = $_POST['type'];
        if (
            empty($_POST['name']) ||
            empty($_POST['descript']) ||
            empty($_POST['github']) ||
            empty($_POST['installer']) ||
            empty($_POST['type']) 
        ) {
            $error = '<div style="color:red;">ERROR EMTY</div>';
        } else {
            $result = $db->CreatePackage(
                $_POST['name'],
                $_POST['descript'],
                $_POST['github'],
                $_POST['installer'],
                $_POST['type']
            );

            if ($result === 200) {
                $error = '<div style="color:red;">ERROR  name has already used</div>';
            } elseif ($result === 400) {
                $error = '<div style="color:green;">Create successfuly </div>';
            } elseif ($result === 300) {
                $error = '<div style="color:red;">name ERROR</div>';
            }
        }
    }



    $title('Package');
    return <<<HTML
        <main class="mx-1 lg:mx-80">
            <div align="center">
                <div class="head">Create package</div>
                <div>
                    {$error}
                    <form class="form" action="/{$user['name']}" method="post">
                        <input type="hidden" name="edit" value="create">
                        <div class="mb-2">
                            <label class="label-dark" for="name">name</label>
                            <input class="input-dark" type="text" name="name" value="{$name}" id="" required>
                        </div>
                        <div class="mb-2">
                            <label class="label-dark" for="description">description</label>
                            <textarea class="textarea-dark" name="descript" id="" rows="5" required>{$descript}</textarea>
                        </div>
                        <div class="mb-2">
                            <label class="label-dark" for="github">Github link</label>
                            <input class="input-dark" type="text" name="github" value="{$github}" id="" required>
                        </div>
                        <div class="mb-2">
                            <label class="label-dark" for="urlbranch">Url branch </label>
                            <input class="input-dark" type="text" name="installer" value="$installer" id="" required>
                        </div>
                        <div class="mb-2">
                            <label class="bg-black text-white p-1 border border-black rounded-l-sm" for="type">type</label><select class="bg-white border border-black p-1  rounded-r-sm" name="type" id="" value="{$type}" required>
                                <option value="1">library</option>
                                <option value="2">template</option>
                            </select>
                        </div>
                        <div class="text-right mb-2">
                            <button class="btn-dark" name="submit">Done</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    HTML;
};
