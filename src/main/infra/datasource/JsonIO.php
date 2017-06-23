<?php
declare(strict_types=1);

class JsonIO {
  private $filename;
  function __construct(
    string $filename
  ) {
    $this->filename = $filename;
  }

  public function load() {
    return $this->loadJson($this->filename);
  }
  public function save($map) {
  }
  public function loadJson($filename) {
    return json_decode(mb_convert_encoding(file_get_contents($filename), 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'));
  }
}
