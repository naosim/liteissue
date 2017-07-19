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

  public function toApiMap() {
    return Mapper::toApiMap(
      $this->messageId,
      $this->issueId,
      $this->userId,
      $this->messageDescription,
      $this->messageCreateDateTime
    );
  }
}

class MessageContainer {
  function __construct(
    IssueId $issueId,
    MessageDescription $messageDescription
  ) {
    eachArgs(func_get_args(), function($k, $v){ $this->$k = $v; });
  }

  function getIssueId(): IssueId {
    return $this->issueId;
  }

  function getMessageDescription(): MessageDescription {
    return $this->messageDescription;
  }
}

interface MessageRepository {
  public function insert(MessageContainer $container);
  public function findAll(IssueId $issueId);
}
