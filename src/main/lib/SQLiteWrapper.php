<?php
interface SQLiteWrapper {
  function executeSql(string $sql, $args);
  function selectSql(string $sql, $args);
}

class SQLiteWrapperImpl implements SQLiteWrapper {
  private $dbfile;
  function __construct(string $dbfile) {
    $this->dbfile = $dbfile;
  }

  function isTable(string $tableName) {
    try {
      $this->executeSql("SELECT ROWID FROM $tableName WHERE ROWID = 1", []);
      return true;
    } catch(Exception $e) {
      return false;
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

  function getLastRowId(string $tableName) {
    return $this->selectSql("SELECT ROWID FROM $tableName WHERE ROWID = last_insert_rowid()", []);
  }

  function selectSql(string $sql, $args) {
    $stmt = $this->executeSql($sql, $args);
    return $stmt->fetchAll();
  }
}

class SQLiteWrapperFactory {
  public function create(string $dbfile): SQLiteWrapper {
    return new SQLiteWrapperImpl($dbfile);
  }
}
