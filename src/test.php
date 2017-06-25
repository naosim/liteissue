<?php
declare(strict_types=1);
include_once "main/loader.php";

load('./main');
loadIn('./test/testlib');
loadIn('./test');

echo '<h1>TEST START</h1>';
eachPhpFile('.', function($file) {
  if(strpos($file, 'Test.php') !== false) {
    $start = strrpos($file, '/') + 1;
    $length = strrpos($file, '.') - $start;
    $className = substr($file, $start, $length);
    (new $className())->run();
  }
});
