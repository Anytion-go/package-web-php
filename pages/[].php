<?php
['getParams' => $getParams, 'title' => $title] = import('wisit-router');
$EditPassword = import('./Cops/users/EditPassword');
$EditAccount = import('./Cops/users/EditDescript');
$Log = import('./Cops/users/Log');
$CreatePackage = import('./Cops/users/CreatePackage');

$NotFoundPage = import("./pages/_error");

$myPackage = function () use ($getParams) {
    $db = new DB;
    $name_user = $getParams(0);
    $data = $db->YourPackage($name_user);

    $content = '';
    foreach ($data as $pac) {
        $type = $pac['type'] == 1 ? 'library' : 'template';
        $content .= <<<HTML
        <div class="card-form">
            <div class="card-name"><a href="/package/{$pac['name']}">{$pac['name']}</a></div>
            <div class="m-2 text-sm">

                <div class="card-box">
                    <span class="card-key">type</span><span class="card-value">{$type}</span>
                </div>
                <div class="card-box">
                    <span class="card-key">last update</span><span class="card-value">{$pac['modif']}</span>
                </div>
                <div class="card-box">
                    <span class="card-key">downloads</span><span class="card-value">{$pac['download']}</span>
                </div>
                <div>
                    <textarea class=" w-full resize-none text-lg bg-white" rows="3" disabled>{$pac['descript']}</textarea>
                </div>
                <div class="my-3">
                        <span class="card-key hover:bg-black">Developer</span><span class="card-value">{$pac['dev']}</span>
                </div>

            </div>
        </div>
        HTML;
    }
    if(empty($content)) $content = <<<HTML
    <div class="head-outline">No any package</div>
    HTML;
    return $content;
};

$export = function () use ($NotFoundPage, $getParams, $title, $EditAccount, $EditPassword, $Log, $CreatePackage,  $myPackage) {
    if (isset($_POST['edit']) && $_POST['edit'] == 'descript') return $EditAccount();
    if (isset($_POST['edit']) && $_POST['edit'] == 'password') return $EditPassword();
    if (isset($_POST['edit']) && $_POST['edit'] == 'log') return $Log();
    if (isset($_POST['edit']) && $_POST['edit'] == 'create') return $CreatePackage();

    $follow = '';
    $db = new DB;
    $user = $db->SearchUser($getParams(0));
    // เช็คว่ามีชื่อผู้ใช้จริงไหม
    if (!$user) return $NotFoundPage();

    // เปลี่ยน title หลังจากเช็คชื่อผู้ใช้
    $title('Account | ' . $user['name']);

    // เช็คว่า login หรือเปล่า เพื่อเช็คต่อไปว่าเป็นบัญชีของตัวเองหรือคนอื่น
    // และเช็คว่าได้ติดตามหรือเปล่า
    if (isset($_COOKIE['token1'])) { // เช็ค ว่ามี token ไหม
        // เช็คว่า token ใช้ได้หรือเปล่า
        $myUser = $db->CheckLogin();
        // เช็คว่ามีคำสั่ง กดติดตามมาหรือไม่ หากมีก็ให้ทำการติดตาม
        if (isset($_POST['follow'])) {
            $db->Follow($myUser['name'], $user['name']);
            header("Refresh:0");
        }

        if ($myUser) {
            // เช็คว่า ได้ติดตามบัญชีนี้หรือไม่
            $result = $db->CheckFollow($myUser['name'], $user['name']);
            // เช็คว่าเป็นบัญชีของตัวเองหรือเปล่า
            if ($myUser['name'] == $user['name']) {
                // ถ้าเป็นบัญชีของตัวเอง จะโชว์ปุ่ม แก้ไข ไปแทน
                $follow = <<<HTML
                    <div class="menu-block block">
                        <form method="post" action="/{$user['name']}">
                            <button class="menu-items" name="edit" value="descript">Edit descript</button>
                            <button class="menu-items" name="edit" value="password">Change password</button>
                            <button class="menu-items" name="edit" value="log">Log</button>
                            <button class="menu-items" name="edit" value="create" >Create package</button>
                        </form>
                    </div>
                HTML;
            } elseif ($result) { // เช็คการติดตาม
                // หากติดตามก็จะโชว์ปุ่ม ติดตามแล้ว 
                $follow = <<<HTML
                    <div class="menu-block block">
                        <form style="display:inline-block;" method="post" action="/{$user['name']}">
                            <button
                            class="menu-items underline"
                            name="follow">Followed</button>
                        </form>
                    </div>
                HTML;
            } else {
                //ถ้ายังไม่ได้ติดตามก็จะโชว์ปุ่มกดติดตาม
                $follow = <<<HTML
                <div class="menu-block block">
                    <form  method="post" action="/{$user['name']}">
                        <button class="menu-items" name="follow">Follow</button>
                    </form>
                </div>
            HTML;
            }
        }
    } else { // ถ้าไม่เจอ token แปลว่ายังไม่ได้ login
        $follow = "";
    }


    return <<<HTML
        <main class="mx-1 lg:mx-80">
            {$follow}
            <div>
                <div class="package-block">
                    <div class="package-name">
                        {$user['name']} 
                    </div>

                    <div class="card-box">
                        <span class="card-key">followers</span><span class="card-value">{$user['follow']}</span>
                    </div>
                    <div class="card-box">
                        <span class="card-key">date register</span><span class="card-value">{$user['date']}</span>
                    </div>

                </div>
                <hr>
                <div >
                    <textarea 
                        class="card-area"
                        disabled
                     cols="10">{$user['descript']}</textarea>
                </div>
                <hr>
                <div class="head">Package</div>
                <div class="">
                    {$myPackage()}
                </div>
            </div>
        </main>
    HTML;
};
