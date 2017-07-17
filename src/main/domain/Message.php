<?php
declare(strict_types=1);

class MessageId extends StringVO {}
class MessageDescription extends StringVO {}
class MessageCreateDateTime extends DateTimeVO {}

class Message {
  function __construct(
    MessageId $messageId,
    IssueId $issueId,
    UserId $userId,
    MessageDescription $messageDescription,
    MessageCreateDateTime $messageCreateDateTime
  ) {
    eachArgs(func_get_args(), function($k, $v){ $this->$k = $v; });
  }
}

class MessageContainer {
  function __construct(
    IssueId $issueId,
    MessageDescription $messageDescription
  ) {
    eachArgs(func_get_args(), function($k, $v){ $this->$k = $v; });
  }
}

interface MessageRepository {
  public function insert(MessageContainer $container);
  public function findAll(IssueId $issueId);
}
