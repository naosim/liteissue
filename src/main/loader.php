<?php
declare(strict_types=1);

function isTargetFile($file) {
  return !strpos($file, 'index.php')
    && strpos($file, '.php');
}

function loadIn($path) {

  foreach(glob($path . '/*') as $file){
    if(is_file($file)){
      if(isTargetFile($file)) {
        include_once $file;
      }
    } else {
      loadIn($file);
    }
  }
}

function load($root) {
  loadIn($root . '/lib');
  loadIn($root . '/domain');
  loadIn($root . '/infra');
  loadIn($root);
}

// loadIn('./lib');
// loadIn('./domain');
// loadIn('./infra');
// loadIn('.');
