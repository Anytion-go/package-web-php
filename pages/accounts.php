<?php
$title = import('wisit-router/title');

$export = function () use ($title) {
    $db = new DB;
    $showAccount = '';
    if(isset($_GET['q'])){
        if(strlen($_GET['q']) < 1 || empty($_GET['q'])) {
            header('Location: /accounts');
            die;
        }
        $allAccount = $db->FindUser($_GET['q']);
    } else {
        $allAccount = $db->AllUser();
    }
    foreach($allAccount as $acc){
        $showAccount .= <<<HTML
        <div class=" border-b border-gray-200 p-3">
            <div class="hover:underline text-2xl "><a href="/{$acc['name']}">{$acc['name']}</a></div>

            <div>
                <textarea class=" w-full resize-none text-md bg-slate-100 p-1 rounded"  rows="3" disabled>{$acc['descript']}</textarea>
            </div>
                
                <div class="inline-block my-3 text-sm">
                    <span class="key">followers</span><span class="value">{$acc['follow']}</span>
                </div>
                <div class="inline-block my-3 text-sm">
                    <span class="key">date register</span><span class="value">{$acc['date']}</span>
                </div>
        </div>
        HTML;
    }


    $title('Accounts');
    $search = $_GET['q'] ?? '';
    return <<<HTML
        <main class="mx-1 lg:mx-80">
            <div>
                <h1 class="head">Accounts</h1>
                <div class="m-3 text-center sm:text-right">
                    <form action="/accounts" >
                        <input class="input-search" type="search" name="q" placeholder="search accounts" value="{$search}">
                        <button class="btn-dark">Search</button>
                    </form>
                </div>
                <div>
                            {$showAccount}
                </div>
            </div>
        </main>
    HTML;
};
