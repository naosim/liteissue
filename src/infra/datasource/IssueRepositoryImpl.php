<?php
declare(strict_types=1);

class IssueRepositoryImpl implements IssueRepository {
  function __construct(
    JsonIO $jsonIO,
    UserId $userId
  ) {
    eachArgs(func_get_args(), function($k, $v){ $this->$k = $v; });
  }

  public function insert(IssueContainer $container) {
  }

  public function findAll() {
  }
}
