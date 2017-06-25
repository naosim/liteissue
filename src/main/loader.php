<?php
declare(strict_types=1);

function isTargetFile($file) {
  return !strpos($file, 'index.php')
    && strpos($file, '.php');
}

function eachPhpFile($path, $callback) {
  foreach(glob($path . '/*') as $file){
    if(strpos($file, '.php')) {
      // echo "$file<br>";
      $callback($file);
    } else {
      eachPhpFile($file, $callback);
    }
  }
}

function loadIn($path, $excludePhp = null) {
  eachPhpFile($path, function($file) use ($excludePhp) {
    if($excludePhp === null || strpos($file, $excludePhp) === false) {
      include_once $file;
    }

  });
}

function load($root) {
  loadIn($root . '/lib', 'index.php');
  loadIn($root . '/domain', 'index.php');
  loadIn($root . '/infra', 'index.php');
  loadIn($root, 'index.php');
}

// loadIn('./lib');
// loadIn('./domain');
// loadIn('./infra');
// loadIn('.');
