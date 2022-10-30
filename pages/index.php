<?php
$title = import('wisit-router/title');

$Welcome = function () use ($title) {
  $title('LTP for PHP');
  return <<<HTML
    <main class="mx-10 lg:mx-80">
      <div class="text-center mb-[100px]">
        <h1 class="p-3 mt-4 text-2xl sm:text-4xl head">Library and Template for PHP </h1>
        <h5 class="text-lg sm:text-2xl sm:mt-14 mb-3 sm:mb-4">Find Library and Template you need </h5>
      <div class="text-center">
        <a href="/package/">
        <button class="big-btn"> <img class="w-12 sm:w-16 inline-block mr-3 bg-white rounded-full p-3" src="/public/folder_icon1.svg" alt="folder-icon"> Packages</button>
        </a>
      </div>
      <div class="text-lg sm:text-2xl mt-3 sm:mt-14 mb-3 sm:mb-4">
        Use <span class=" bg-slate-200 p-1 rounded">Control</span> to install Library and Template
      </div>
      <div>
        <a target="_blank" href="https://github.com/arikato111/control">
          <button class="big-btn">Control</button>
        </a>
      </div>
      </div>
    </main>
  HTML;
};

$Home = function () use ($title, $Welcome) {
  if (!isset($_COOKIE['token1'])|| !isset($_GET['feed'])) return $Welcome();
  $db = new DB;
  $user = $db->CheckLogin();
  $db->Feed();
  $content = '';

  $data = $db->Feed();
  foreach ($data as $pac) {
    $type = $pac['type'] == 1 ? 'library' : 'template';
    $content .= <<<HTML
    <div class=" border-b-2 border-black p-3">
        <div class="hover:underline text-2xl "><a href="/package/{$pac['name']}">{$pac['name']}</a></div>
        <div class="m-2 text-sm">

            <div class="inline-block my-3">
                <span class="bg-black border border-black text-white p-1">type</span><span class="bg-white text-black p-1 border border-black mr-1">{$type}</span>
            </div>
            <div class="inline-block my-3">
                <span class="bg-black border border-black text-white p-1">last update</span><span class="bg-white text-black p-1 border border-black mr-1">{$pac['modif']}</span>
            </div>
            <div class="inline-block my-3">
                <span class="bg-black border border-black text-white p-1">downloads</span><span class="bg-white text-black p-1 border border-black mr-1">{$pac['download']}</span>
            </div>
            <div>
                <textarea class=" w-full resize-none text-lg bg-slate-100" rows="3" disabled>{$pac['descript']}</textarea>
            </div>
            <div class="my-3">
                <a href="/{$pac['dev']}">
                    <span class="bg-black border border-black text-white p-1">Developer</span><span class="bg-white text-black p-1 border border-black mr-1">{$pac['dev']}</span>
                </a>
            </div>

        </div>
    </div>
    HTML;
}

  $title('Home'); // use title function to change title
  return <<<HTML
    <main class="mx-1 lg:mx-80">
      <div>
        <div class="head">Feed</div>
        <hr>
        {$content}
      </div>
    </main>
    HTML;
};

$export = $Home;
