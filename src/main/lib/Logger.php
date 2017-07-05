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

class Logger {
  public static $outputType = 'html';//html or plain

  private static function printHtml($func) {
    echo("<pre><code>");
    echo (new DateTime())->format(DateTime::ISO8601) . ' ';
    $func();
    echo("</code></pre>");
  }

  private static function print($func) {
    if(self::$outputType == 'html') {
      self::printHtml($func);
    } else {
      throw new RuntimeException('outputType not found: ' . $outputType);
    }
  }

  public static function log($str) {
    self::print(function() use($str) {
      echo($str);
    });
  }

  public static function dump($obj) {
    self::print(function() use($obj) {
      var_dump($obj);
    });
    return $obj;
  }
}
