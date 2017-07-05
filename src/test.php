<?php
declare(strict_types=1);
include_once "main/loader.php";

setupInclude('./main');
(new EasyInclude('.', null))->load(
  'https://gist.githubusercontent.com/naosim/ba8300f7cc70f7ee4a8bbc1b9f43b45f/raw/TestUtil.php',
  // '/test/testlib',
  '/test'
);

$allTestResult = [];
EasyInclude::eachPhpFile('.', function($file) use(&$allTestResult) {
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
