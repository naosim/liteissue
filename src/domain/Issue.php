<?php
class IssueId extends StringVO {}
class IssueTitle extends StringVO {}
class IssueDescription extends StringVO {}
class IssueCreateDateTime extends DateTimeVO {}

interface IssueStatus {
  public function getValue();
}
class IssueStatusOpen implements IssueStatus {
  public function getValue() { return "open"; }
}
class IssueStatusClose implements IssueStatus {
  public function getValue() { return "close"; }
}

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
}

class IssueContainer {
  function __construct(
    IssueTitle $issueTitle,
    IssueDescription $issueDescription,
    IssueStatus $issueStatus
  ) {
    eachArgs(func_get_args(), function($k, $v){ $this->$k = $v; });
  }
}

interface IssueRepository {
  public function insert(IssueContainer $container);
  public function findAll();
}
