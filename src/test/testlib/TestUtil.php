<?php
class Test {
  function setupAll() {}
  function cleanupAll() {}
  function setup() {}
  function cleanup() {}
  function run() {
    assert_options(ASSERT_ACTIVE, 1);
    assert_options(ASSERT_WARNING, 1);
    assert_options(ASSERT_QUIET_EVAL, 0);
    assert_options(ASSERT_EXCEPTION, 1);
    $className = get_class($this);
    echo "<h3>$className</h3>";
    $this->setupAll();
    foreach (get_class_methods($this) as $methodName) {
      if(strpos($methodName, 'test') !== false) {
        $this->_run($methodName);
      }
    }
    $this->cleanupAll();
  }
  private function _run($methodName) {
    try {
      $this->setup();
      $this->$methodName();
      echo "<h4>$methodName OK</h4>";
    } catch(Exception $e) {
      echo "<h4>$methodName NG</h4>";
      echo "<pre><code>$e</code></pre>";
    } catch(Error $e) {
      echo "<h4>$methodName NG</h4>";
      echo "<pre><code>$e</code></pre>";
    } finally {
      $this->cleanup();
    }
  }
}

class TestClassName extends StringVO {}
class TestMethodName extends StringVO {}
class TestResultType extends StringVO {
  private $ngReason;

  public function __construct(string $value, string $ngReason = null) {
    $this->value = $value;
    $this->ngReason = $ngReason;
  }

  public static function ok() { return new TestResultType("ok"); }
  public static function ng(string $ngReason) {
    return new TestResultType("ng", $ngReason);
  }
}

class TestResult {
  function __construct(
    TestClassName $testClassName,
    TestMethodName $testMethodName,
    TestResultType $testResultType
  ) {
    eachArgs(func_get_args(), function($k, $v){ $this->$k = $v; });
  }
}
