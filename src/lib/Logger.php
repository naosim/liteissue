<?php
function logger_log($str) {
  echo($str . "<br>");
}

function logger_dump($obj) {
  var_dump($obj);
  echo("<br>");
  echo("<br>");
}
