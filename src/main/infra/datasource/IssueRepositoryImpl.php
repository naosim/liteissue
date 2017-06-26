<?php
declare(strict_types=1);

class IssueRepositoryImpl implements IssueRepository {
  private $sqlite;
  private $authedUserId;
  function __construct(
    SQLiteWrapperFactory $sqliteWrapperFactory,
    AuthedUserId $authedUserId
  ) {
    $this->sqlite = $sqliteWrapperFactory->create('issue.db');
    $this->authedUserId = $authedUserId;

    if(!$this->sqlite->isTable('issue')) {
      $createTable = 'CREATE TABLE issue(title, description, status, user_id, timestamp)';
      $this->sqlite->executeSql($createTable, []);
    }
    $this->sqlite->getLastRowId('issue');
  }

  public function insert(IssueContainer $container) {
  }

  public function findAll() {
  }
}
