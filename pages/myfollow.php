<?php
$title = import('wisit-router/title');


$export = function () use ($title) {
    $db = new DB;
    $showAccount = '';
    $allAccount = $db->MyFollow();
    if ($allAccount) {
        foreach ($allAccount as $acc) {
            $showAccount .= <<<HTML
             <div class="text-2xl shadow-md text-center p-2" style="margin:10px;"><a class="hover:underline" href="/{$acc['def']}">{$acc['def']}</a></div>
             HTML;
        }
    } else {
        $showAccount = <<<HTML
            <div class="head">Not found any follow</div>
        HTML;
    }


    $title('Accounts');
    return <<<HTML
        <main class="mx-1 lg:mx-80">
            <div>
                <h1 class="head ">My follow</h1>
                <div>
                    {$showAccount}
                </div>
            </div>
        </main>
    HTML;
};
