<?php
declare(strict_types=1);

class IssueRepositoryImplTest extends Test {

  private $issueRepository;

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

  function test_hoge() {
    $this->issueRepository->insert(new IssueContainer(
      new IssueTitle("ttt"),
      new IssueDescription("ddd"),
      new IssueStatusOpen()
    ));
    logger_dump($this->issueRepository->findAll());
  }

  function test_find_none() {
    assert($this->issueRepository->findAll()->count() == 0);
  }
}
