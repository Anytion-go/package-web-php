<?php
$export = function () {
    return <<<HTML
        <footer class="flex justify-between">
            <div class="p-2">
                <a class="hover:underline" href="/privacy">privacy</a>
            </div>
            <div class="text-center mt-1">
                <a class="hover:underline" href="https://github.com/Anytion-go/package-web-php">
                <img style="display: inline-block;width: 32px;" src="/public/github_icon.svg" alt="github icon">
                    Source code</a>
            </div>
            <div class="text-sm text-right" align="right" style="margin: 10px;">© Copyright Anytion. All Rights Reserved</div>
        </footer>
    HTML;
};
