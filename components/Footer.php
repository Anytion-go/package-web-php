<?php
$export = function () {
    return <<<HTML
        <footer class=" bg-black bg-opacity-80 text-white sm:grid grid-cols-3">

            <div class="p-2 text-center sm:flex flex-col justify-center items-start">
                <a class="hover:underline inline-block" href="/privacy">privacy</a>
            </div>
            <div class="text-center mt-1 sm:flex flex-col justify-center">
                <a class="hover:underline" href="https://github.com/Anytion-go/package-web-php">
                <img style="display: inline-block;width: 32px;" src="/public/github_icon.svg" alt="github icon">
                    Source code</a>
            </div>
            <div class="text-sm text-center flex flex-col justify-center items-end" align="right" style="margin: 10px;">© Copyright Anytion. All Rights Reserved</div>
        </footer>
    HTML;
};
