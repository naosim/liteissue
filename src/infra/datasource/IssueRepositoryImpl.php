<?php
declare(strict_types=1);

class IssueRepositoryImpl implements IssueRepository {
  private $sqlite;
  private $authedUserId;
  function __construct(
    SQLiteWrapperFactory $sqliteWrapperFactory,
    AuthedUserId $authedUserId
  ) {
    logger_dump($sqliteWrapperFactory);
    $this->sqlite = $sqliteWrapperFactory->create('issue.db');
    $this->authedUserId = $authedUserId;

    $this->sqlite->initTable('issue', function() {
      $this->sqlite->executeSql('CREATE TABLE issue(title)', []);
      logger_dump($this->sqlite);
    });

  }

  public function insert(IssueContainer $container) {
  }

  public function findAll() {
  }
}
