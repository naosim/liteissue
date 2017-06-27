<?php
declare(strict_types=1);

class IssueRepositoryImpl implements IssueRepository {
  private $sqlite;
  private $authedUserId;
  public static $DB_FILE = './data/db/issue.db';
  function __construct(
    SQLiteWrapperFactory $sqliteWrapperFactory,
    AuthedUserId $authedUserId
  ) {
    $this->sqlite = $sqliteWrapperFactory->create(self::$DB_FILE);
    $this->authedUserId = $authedUserId;

    if(!$this->sqlite->isTable('issue')) {
      $createTable = 'CREATE TABLE issue(id INTEGER PRIMARY KEY AUTOINCREMENT, title, description, status, user_id, timestamp)';
      $this->sqlite->executeSql($createTable, []);
    }
    //$this->sqlite->getLastRowId('issue');
  }

  public function insert(IssueContainer $container) {
    /*
    IssueTitle $issueTitle,
    IssueDescription $issueDescription,
    IssueStatus $issueStatus
    */
    $insert = "INSERT INTO issue(title, description, status, user_id, timestamp) VALUES (?, ?, ?, ?, ?)";
    $this->sqlite->executeSql($insert, [
      $container->getIssueTitle(),
      $container->getIssueDescription(),
      $container->getIssueStatus(),
      $this->authedUserId,
      new DateTimeVO(new DateTime())
    ]);
  }

  public function findAll() {
    return $this->sqlite->selectSql('SELECT * FROM issue', []);
  }
}
