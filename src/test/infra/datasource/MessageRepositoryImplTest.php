<?php
declare(strict_types=1);

class MessageRepositoryImplTest extends Test {
  function setup() {
    if(file_exists(IssueRepositoryImpl::$DB_FILE)) {
      unlink(IssueRepositoryImpl::$DB_FILE);
    }

    $sqliteWrapperFactory = new SQLiteWrapperFactory();
    $this->issueRepository = new IssueRepositoryImpl(
      $sqliteWrapperFactory,
      new DateTimeFactoryImpl(),
      new AuthedUserId(new UserId('admin'))
    );
  }

  function cleanup() {
    if(file_exists(IssueRepositoryImpl::$DB_FILE)) {
      unlink(IssueRepositoryImpl::$DB_FILE);
    }
  }
}