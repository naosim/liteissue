<?php
class JsonIO {
  private $filename;
  function __construct(
    string $filename
  ) {
    $this->filename = $filename;
  }

  public function load() {
    return loadJson($this->filename);
  }

  public function save($map) {
  }
}
