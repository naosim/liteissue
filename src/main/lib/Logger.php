<?php
declare(strict_types=1);
function logger_log($str) {
  echo($str . "<br>");
}

function logger_dump($obj) {
  echo("<pre><code>");
  var_dump($obj);
  echo("</code></pre>");
  return $obj;
}
