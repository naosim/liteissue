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
    $result = [];
    $className = new TestClassName(get_class($this));
    $this->setupAll();
    foreach (get_class_methods($this) as $methodName) {
      if(strpos($methodName, 'test') !== false) {
        $result[] = $this->_run($className, new TestMethodName($methodName));
      }
    }
    $this->cleanupAll();
    return $result;
  }
  private function _run(TestClassName $testClassName, TestMethodName $testMethodName) {
    try {
      $this->setup();
      $methodName = $testMethodName->getValue();
      $this->$methodName();
      return new TestResult(
        $testClassName,
        $testMethodName,
        TestResultType::ok()
      );
    } catch(Exception $e) {
      return new TestResult(
        $testClassName,
        $testMethodName,
        TestResultType::ng($e)
      );
    } catch(Error $e) {
      return new TestResult(
        $testClassName,
        $testMethodName,
        TestResultType::ng($e)
      );
    } finally {
      $this->cleanup();
    }
  }
}

class TestClassName extends StringVO {}
class TestMethodName extends StringVO {}
class TestResultType extends StringVO {
  public $ngReason;

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
