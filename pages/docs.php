<?php
$title = import('wisit-router/title');

$export = function () use ($title) {
    $title('Docs');

    return <<<HTML
    <main class="mx-0 p-1 lg:mx-80">
        <h1 class="head">Docs</h1>
        <div class="text-center text-lg sm:text-2xl">
            How to install Library and Template ?
        </div>
        <div class="text-center text-lg sm:text-lg my-2">
            You can use <span class=" border border-black p-1 rounded">control</span> with library name or template name to install
        </div>
        <div class="text-center text-lg font-bold bg-slate-200 mt-10 p-2 my-2" >Install control with your terminal (bash, cmd, powershell)</div>
        <dir class="">copy this command and run on your project folder</dir>
        <div class="text-right m-3">
            <button title="click to copy" class="p-1 border-2 border-black bg-white rounded" id="copy-command" onclick="copyCommand()">copy</button>
        </div>
        <div class="overflow-hidden">
            <textarea class="resize-none border-2 border-slate-200 p-1 rounded w-full text-sm h-auto my-2" disabled>curl https://raw.githubusercontent.com/Arikato111/control/master/control -O control</textarea>
        </div>
        <script>
            function copyCommand() {
                navigator.clipboard.writeText(`curl https://raw.githubusercontent.com/Arikato111/control/master/control -O control`);
                var btnC = document.getElementById("copy-command")
                btnC.style.backgroundColor = 'black';
                btnC.style.color = 'white'
                btnC.innerText = 'copied'
                setTimeout(() => {
                    btnC.style.backgroundColor = 'white';
                    btnC.style.color = 'black'
                    btnC.innerText = 'copy'
                    
                }, 3000);
            }
        </script>
        <hr>
        <div class="text-center text-lg font-bold bg-slate-200 mt-10 p-2 my-2">Install with create file</div>
        <dir class=" my-3">you can create file with the name <span class="p-1 border border-black rounded">control</span> in your project.</dir>
        <dir class="">and copy code below , past it in control</dir>
        <div class="text-right m-3">
            <button title="click to copy" class="p-1 border-2 border-black bg-white rounded" id="copy-1" onclick="myFunction()">copy</button>
        </div>
        <div class="overflow-hidden">
            <textarea class="resize-none border-2 border-slate-200 p-1 rounded w-full text-sm h-auto my-2" rows="3" disabled><?php eval(substr(file_get_contents('https://raw.githubusercontent.com/Arikato111/control/master/control'), 6));</textarea>
        </div>
        <script>
            function myFunction() {
                navigator.clipboard.writeText(`<?php eval(substr(file_get_contents('https://raw.githubusercontent.com/Arikato111/control/master/control'), 6));`);
                var btnC = document.getElementById("copy-1")
                btnC.style.backgroundColor = 'black';
                btnC.style.color = 'white'
                btnC.innerText = 'copied'
                setTimeout(() => {
                    btnC.style.backgroundColor = 'white';
                    btnC.style.color = 'black'
                    btnC.innerText = 'copy'
                    
                }, 3000);
            }
        </script>
        <div class="text-center">
            <a target="_blank" href="https://github.com/Arikato111/control">
                <button class="btn-github"><img class="img-github" src="/public/github_icon.svg" alt="github logo">Control</button>
            </a>
        </div>
    </main>
    HTML;
};
