<?php
declare(strict_types=1);

class MessageRepositoryImpl implements MessageRepository {
  private $sqlite;
  private $dateTimeFactory;
  private $authedUserId;
  public static $DB_FILE = './data/db/message.db';
  function __construct(
    SQLiteWrapperFactory $sqliteWrapperFactory,
    DateTimeFactory $dateTimeFactory,
    AuthedUserId $authedUserId
  ) {
    $this->sqlite = $sqliteWrapperFactory->create(self::$DB_FILE);
    $this->dateTimeFactory = $dateTimeFactory;
    $this->authedUserId = $authedUserId;

    if(!$this->sqlite->isTable('message')) {
      $createTable = 'CREATE TABLE message(id INTEGER PRIMARY KEY AUTOINCREMENT, description, user_id, issue_id, timestamp)';
      $this->sqlite->executeSql($createTable, []);
    }
    //$this->sqlite->getLastRowId('issue');
  }

  public function insert(MessageContainer $container) {
    $insert = "INSERT INTO issue(description, user_id, issue_id, timestamp) VALUES (?, ?, ?, ?)";
    $this->sqlite->executeSql($insert, [
      $container->getIssueDescription(),
      $this->authedUserId,
      $container->getIssueId(),
      $this->dateTimeFactory->createUnixDateTime()
    ]);
  }

  public function findAll(IssueId $issueId): Stream {
    $result = $this->sqlite->selectSql('SELECT * FROM message WHERE issue_id = ?', [$issueId]);
    return Stream::ofAll($result)
    ->map(function($map){
      $d = (new UnixTimestampVO((int)$map['timestamp']))->toDateTime();
      return new Message(
        new MessageId($map['id']),
        new IssueId($map['issue_id']),
        new UserId($map['user_id']),
        new MessageDescription($map['description']),
        new MessageCreateDateTime($d)
      );
    });
  }
}
