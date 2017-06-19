<?php
function loadIn($path) {
  foreach(glob($path . '/*') as $file){
    if(is_file($file)){
      if(strpos($file, '.php')) {
        include_once $file;
      }
    } else {
      loadIn($file);
    }
  }
}
loadIn('./lib');
loadIn('./domain');
loadIn('./infra');
loadIn('.');
