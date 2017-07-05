<?php
declare(strict_types=1);

// snipet form https://gist.github.com/naosim/3f18a045222faffd4bf80903e42b8bef
function includeFromWeb($url, $root = '.') {
  $file = $root . '/vendor/' . explode('//', $url)[1];
  $dir = substr($file, 0, strrpos($file, '/'));
  if(!file_exists($file)) {
    if(!file_exists($dir)) {
      mkdir($dir, 0777, true);
    }
    $text = trim(file_get_contents($url));
    if(strpos($text, '<?php') === false) {
      throw new RuntimeException("Not PHP FILE: " . $url);
    }
    file_put_contents($file, $text);
  }

  include_once $file;
}

function setupInclude($root) {
  includeFromWeb('https://gist.githubusercontent.com/naosim/4492b8054564f13998fa51be03ec0340/raw/EasyInclude.php', $root);
  (new EasyInclude($root, 'index.php'))->load(
    'https://gist.githubusercontent.com/naosim/ba8300f7cc70f7ee4a8bbc1b9f43b45f/raw/Stream.php',
    'https://gist.githubusercontent.com/naosim/ba8300f7cc70f7ee4a8bbc1b9f43b45f/raw/SQLiteWrapper.php',
    '/lib',
    '/domain',
    '/infra',
    'index.php'
  );
}
