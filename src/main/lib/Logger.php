<?php
declare(strict_types=1);

function logger_log($str) {
  if($isDebugMode === false) {
    return;
  }
  echo($str . "<br>");
}

function logger_dump($obj) {
  if($isDebugMode === false) {
    return $obj;
  }
  echo("<pre><code>");
  var_dump($obj);
  echo("</code></pre>");
  return $obj;
}
