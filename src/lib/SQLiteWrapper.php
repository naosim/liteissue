<?php
interface SQLiteWrapper {
  function initTable(string $tableName, $createTableRunnable);
  function executeSql(string $sql, $args);
  function selectSql(string $sql, $args);
}

class SQLiteWrapperImpl implements SQLiteWrapper {
  private $dbfile;
  function __constractor(string $dbfile) {
    $this->dbfile = $dbfile;
  }

  function initTable(string $tableName, $createTableRunnable) {
    try {
      $this->executeSql("SELECT ROWID FROM ? WHERE ROWID = 1", [$tableName]);
    } catch(Exception $e) {
      $createTableRunnable();
    }

  }

  function executeSql(string $sql, $args) {
    $pdo = new PDO('sqlite:' . $this->dbfile);
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

  function selectSql(string $sql, $args) {
    $stmt = executeSql($sql, $args);
    return $stmt->fetchAll();
  }
}

class SQLiteWrapperFactory {
  public function create(string $dbfile): SQLiteWrapper {
    return new SQLiteWrapperImpl($dbfile);
  }
}
