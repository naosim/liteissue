<?php

class WebDependenceLoad {
  private $root;
  private $excludePhp;
  public function __construct($root, $excludePhp = null) {
    $this->root = $root;
    $this->excludePhp = $excludePhp;
  }
  private function loadFromWeb($url) {
    $file = $this->root . '/vendor/' . explode('//', $url)[1];
    $dir = substr($file, 0, strrpos($file, '/'));
    if(!file_exists($file)) {
      if(!file_exists($dir)) {
        mkdir($dir, 0777, true);
      }
      $text = trim(file_get_contents($url));
      if(strpos($text, '<?php') === false) {
        throw new RuntimeException("Not PHP FILE: " . $url);
      }
      file_put_contents($file, $text);
    }

    include_once $file;
  }

  public static function eachPhpFile($path, $callback) {
    foreach(glob($path . '/*') as $file){
      if(strpos($file, '.php')) {
        // echo "$file<br>";
        $callback($file);
      } else {
        self::eachPhpFile($file, $callback);
      }
    }
  }

  private function loadFromDir($path) {
    self::eachPhpFile($this->root . $path, function($file) {
      if($this->excludePhp === null || strpos($file, $this->excludePhp) === false) {
        include_once $file;
      }

    });
  }

  public function load(...$ary) {
    foreach($ary as $v) {
      if(strpos($v, 'http') === 0) {
        $this->loadFromWeb($v);
      } else {
        $this->loadFromDir($v);
      }

    }
  }

}
