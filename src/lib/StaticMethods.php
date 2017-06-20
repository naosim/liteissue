<?php
declare(strict_types=1);

function eachArgs($args, $consumer_k_v) {
  foreach($args as $value) {
    $c = get_class($value);
    $key = strtolower(substr($c, 0, 1)) . substr($c, 1);
    $consumer_k_v($key, $value);
  }
}

function sqlite_open($location) {
    $handle = new SQLite3($location);
    return $handle;
}
function sqlite_query($dbhandle, $query) {
    $array['dbhandle'] = $dbhandle;
    $array['query'] = $query;
    $result = $dbhandle->query($query);
    return $result;
}

function executeSql(string $dbfile, string $sql, $args) {
  $pdo = new PDO('sqlite:' . $dbfile);
  // SQL実行時にもエラーの代わりに例外を投げるように設定
  // (毎回if文を書く必要がなくなる)
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // デフォルトのフェッチモードを連想配列形式に設定
  // (毎回PDO::FETCH_ASSOCを指定する必要が無くなる)
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  $stmt = $pdo->prepare($sql);
  $stmt->execute($args);
  return $stmt;
}

function selectSql(string $dbfile, string $sql, $args) {
  $stmt = executeSql($dbfile, $sql, $args);
  return $stmt->fetchAll();
}
