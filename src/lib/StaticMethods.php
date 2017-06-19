<?php
function eachArgs($args, $consumer_k_v) {
  foreach($args as $value) {
    $c = get_class($value);
    $key = strtolower(substr($c, 0, 1)) . substr($c, 1);
    $consumer_k_v($key, $value);
  }
}

function loadJson($filename) {
  return json_decode(mb_convert_encoding(file_get_contents($filename), 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'));
}
