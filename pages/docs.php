<?php
$title = import('wisit-router/title');

$export = function () use ($title) {
    $title('Docs');

    return <<<HTML
    <main class="mx-1 lg:mx-80">
        <h1 class="head">Docs</h1>
        <div class="text-center text-lg sm:text-2xl">
            How to install Library and Template ?
        </div>
        <div class="text-lg sm:text-lg text-center my-2">
            You can use <span class=" border border-black p-1 rounded">control</span> with library name or template name to install
        </div>
        <div class="text-lg text-center bg-slate-200 mt-10 p-2 m-2">Install control</div>
        <div class="text-lg text-center font-bold" >Install with cmd or poswershell</div>
        <div class="text-center">copy this command and run on your project folder</div>
        <div class="text-center m-3">
            <button class="p-1 border-2 border-black bg-white rounded" id="copy-command" onclick="copyCommand()">copy</button>
        </div>
        <textarea class="resize-none border-2 border-slate-200 p-1 rounded w-full text-sm h-auto m-2" disabled>curl https://raw.githubusercontent.com/Arikato111/control/master/control -O control</textarea>
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
        <div class="text-lg text-center font-bold">Install with create file</div>
        <div class="text-center my-3">you can create file with the name <span class="p-1 border border-black rounded">control</span> in your project.</div>
        <div class="text-center">and copy code below , past it in control</div>
        <div class="text-center m-3">
            <button class="p-1 border-2 border-black bg-white rounded" id="copy-1" onclick="myFunction()">copy</button>
        </div>
        <textarea class="resize-none border-2 border-slate-200 p-1 rounded w-full text-sm h-auto m-2" disabled><?php eval(substr(file_get_contents('https://raw.githubusercontent.com/Arikato111/control/master/control'), 6));</textarea>
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
