<?php
declare(strict_types=1);

class IssueRepositoryImpl implements IssueRepository {
  private $sqlite;
  private $dateTimeFactory;
  private $authedUserId;
  public static $DB_FILE = './data/db/issue.db';
  function __construct(
    SQLiteWrapperFactory $sqliteWrapperFactory,
    DateTimeFactory $dateTimeFactory,
    AuthedUserId $authedUserId
  ) {
    $this->sqlite = $sqliteWrapperFactory->create(self::$DB_FILE);
    $this->dateTimeFactory = $dateTimeFactory;
    $this->authedUserId = $authedUserId;

    if(!$this->sqlite->isTable('issue')) {
      $createTable = 'CREATE TABLE issue(id INTEGER PRIMARY KEY AUTOINCREMENT, title, description, status, user_id, timestamp)';
      $this->sqlite->executeSql($createTable, []);
    }
    //$this->sqlite->getLastRowId('issue');
  }

  public function insert(IssueContainer $container) {
    $insert = "INSERT INTO issue(title, description, status, user_id, timestamp) VALUES (?, ?, ?, ?, ?)";
    $this->sqlite->executeSql($insert, [
      $container->getIssueTitle(),
      $container->getIssueDescription(),
      $container->getIssueStatus(),
      $this->authedUserId,
      $this->dateTimeFactory->createUnixDateTime()
    ]);
  }

  public function findAll(): Stream {
    $result = $this->sqlite->selectSql('SELECT * FROM issue', []);
    return Stream::ofAll($result)
    ->map(function($map){
      $d = (new UnixTimestampVO((int)$map['timestamp']))->toDateTime();
      return new Issue(
        new IssueId($map['id']),
        new IssueTitle($map['title']),
        new IssueDescription($map['description']),
        new IssueCreateDateTime($d),
        $map['status'] == 'open' ? new IssueStatusOpen() : new IssueStatusClose(),
        new UserId($map['user_id'])
      );
    });
  }
}

/*
class Issue {
  function __construct(
    IssueId $issueId,
    IssueTitle $issueTitle,
    IssueDescription $issueDescription,
    IssueCreateDateTime $issueCreateDateTime,
    IssueStatus $issueStatus,
    UserId $userId
  ) {
    eachArgs(func_get_args(), function($k, $v){ $this->$k = $v; });
  }
}*/
