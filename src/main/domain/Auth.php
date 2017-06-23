<?php
declare(strict_types=1);

class UserPassword extends StringVO {}
class AuthedUser {
  function __construct(
    AuthedUserId $authedUserId,
    UserPassword $pserPassword
  ) {
    eachArgs(func_get_args(), function($k, $v){ $this->$k = $v; });
  }
}

interface AuthRepository {
  public function auth(UserId $userId, UserPassword $password): AuthedUserId;// AuthedUserId or false
  public function updatePassword(AuthedUserId $authedUserId, UserPassword $userPassword);
}
