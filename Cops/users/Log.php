<?php
$title = import('wisit-router/title');

$export = function() use ($title) {
    $db = new DB;

    if(isset($_POST['delete']) && !empty($_POST['delete'])){
        $db->DeleteLog($_POST['delete']);
    }

    $user = $db->CheckLogin();
    $data = $db->ShowLog();

    $showLog = '';
    foreach($data as $log){
        $showLog .= <<<HTML
            <tr>
                <td>{$log['id']}</td>
                <td>{$log['token1']}</td>
                <td>{$log['date']}</td>
                <td><form action="/{$user['name']}" method="post">
                    <input type="hidden" name="edit" value="log">
                    <button
                        style="background-color:red;color:white;border-color:white;"
                        type="submit"
                        class="btn"
                        name="delete"
                        value="{$log['id']}"
                    >Delete</button>
                </form></td>
            </tr>
        HTML;
    }

    $title($user['name'] . ' | Log');
    return <<<HTML
        <main class="mx-10">
            <div>
                <p>Log</p>
                <hr>
                <div class=" overflow-x-scroll text-center">
                    <table class="w-full">
                        <thead>
                            <th>id</th>
                            <th>token</th>
                            <th>date create</th>
                            <th>delete</th>
                        </thead>
                        {$showLog}
                    </table>
                </div>
            </div>
        </main>
    HTML;
};