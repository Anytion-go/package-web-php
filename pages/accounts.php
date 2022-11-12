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
        <div class="card-form">
            <div class="card-name"><a href="/{$acc['name']}">{$acc['name']}</a></div>
            <div>
                <textarea class=" w-full resize-none text-lg bg-slate-100 p-1 rounded"  rows="3" disabled>{$acc['descript']}</textarea>
            </div>
                
                <div class="card-box">
                    <span class="card-key">followers</span><span class="card-value">{$acc['follow']}</span>
                </div>
                <div class="card-box">
                    <span class="card-key">date register</span><span class="card-value">{$acc['date']}</span>
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
                        <input class="input-search border border-slate-500 rounded-md" type="search" name="q" placeholder="search accounts" value="{$search}">
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
