<?php
class Test {
  function setupAll() {}
  function cleanupAll() {}
  function setup() {}
  function cleanup() {}
  function run() {
    $this->setupAll();
    foreach (get_class_methods($this) as $methodName) {
      if(strpos($methodName, 'test') !== false) {
        $this->$methodName();
      }
    }
    $this->cleanupAll();
  }
  private function _run($methodName) {
    $this->setup();
    $this->$methodName();
    $this->cleanup();
  }
}

class TargetTest extends Test {
  function test_hoge() {
    echo "hello";
  }
}

$t = new TargetTest();
$t->run();
