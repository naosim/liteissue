<?php
declare(strict_types=1);

class IssueRepositoryImplTest extends Test {

  private $issueRepository;

  function setup() {
    $sqliteWrapperFactory = new SQLiteWrapperFactory();
    $this->issueRepository = new IssueRepositoryImpl(
      $sqliteWrapperFactory,
      new AuthedUserId(new UserId('admin'))
    );

  }

  function test_hoge() {
    $sut = new IssueRepositoryImpl();
  }
}
