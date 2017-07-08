<?php
declare(strict_types=1);

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
  private $issueStatus;
  function __construct(
    IssueId $issueId,
    IssueTitle $issueTitle,
    IssueDescription $issueDescription,
    IssueCreateDateTime $issueCreateDateTime,
    IssueStatus $issueStatus,
    UserId $userId
  ) {
    eachArgs(func_get_args(), function($k, $v){ $this->$k = $v; });
    $this->issueStatus = $issueStatus;
  }

  public function toMap() {
    return array(
      'issueId' => $this->issueId->getValue(),
      'issueTitle' => $this->issueTitle->getValue(),
      'issueDescription' => $this->issueDescription->getValue(),
      'issueCreateDateTime' => $this->issueCreateDateTime->getApiValue(),
      'issueStatus' => $this->issueStatus->getValue(),
      'userId' => $this->userId->getValue(),
    );
  }
}

class IssueContainer {
  private $issueTitle;
  private $issueDescription;
  private $issueStatus;
  function __construct(
    IssueTitle $issueTitle,
    IssueDescription $issueDescription,
    IssueStatus $issueStatus
  ) {
    $this->issueTitle = $issueTitle;
    $this->issueDescription = $issueDescription;
    $this->issueStatus = $issueStatus;
  }

  public function getIssueTitle(): IssueTitle {
    return $this->issueTitle;
  }

  public function getIssueDescription(): IssueDescription {
    return $this->issueDescription;
  }

  public function getIssueStatus(): IssueStatus {
    return $this->issueStatus;
  }
}

interface IssueRepository {
  public function insert(IssueContainer $container);
  public function findAll();
}
