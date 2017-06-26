<?php
declare(strict_types=1);
include_once "main/loader.php";

load('./main');
loadIn('./test/testlib');
loadIn('./test');

$allTestResult = [];
eachPhpFile('.', function($file) use(&$allTestResult) {
  if(strpos($file, 'Test.php') !== false) {
    $start = strrpos($file, '/') + 1;
    $length = strrpos($file, '.') - $start;
    $className = substr($file, $start, $length);
    $r = (new $className())->run();
    $allTestResult = array_merge($allTestResult, $r);
    // $allTestResult[] = $r;
  }
});

echo "<ul>";
foreach($allTestResult as $r) {
  echo "<li>{$r->testClassName->getValue()} {$r->testMethodName->getValue()} {$r->testResultType->getValue()} {$r->testResultType->getValue()} <pre><code>{$r->testResultType->ngReason}</pre></code></li>";
}
echo "</ul>";
