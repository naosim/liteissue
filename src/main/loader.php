<?php
declare(strict_types=1);

// function isTargetFile($file) {
//   return !strpos($file, 'index.php')
//     && strpos($file, '.php');
// }

function load($root) {
  include_once "lib/WebDependenceLoad.php";
  (new WebDependenceLoad($root, 'index.php'))->load(
    'https://gist.githubusercontent.com/naosim/ba8300f7cc70f7ee4a8bbc1b9f43b45f/raw/Stream.php',
    'https://gist.githubusercontent.com/naosim/ba8300f7cc70f7ee4a8bbc1b9f43b45f/raw/106abe83ed746720f7f2291fae57d6d8173ecd5e/SQLiteWrapper.php',
    '/lib',
    '/domain',
    '/infra',
    'index.php'
  );
}
