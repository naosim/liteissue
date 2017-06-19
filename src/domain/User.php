<?php
class UserId extends StringVO {}
class AuthedUserId extends UserId {}
class UserName extends StringVO {}
class UserPassword extends StringVO {}

class User {
  function __construct(
    UserId $userId,
    UserName $userName
  ) {
    eachArgs(func_get_args(), function($k, $v){ $this->$k = $v; });
  }
}

class AuthedUser {
  function __construct(
    AuthedUserId $authedUserId,
    User $user
  ) {
    eachArgs(func_get_args(), function($k, $v){ $this->$k = $v; });
  }
}

interface UserRepository {
  public function find(UserId $userId);
  public function auth(UserId $userId, UserPassword $password);// true or false
  public function updatePassword(AuthedUserId $authedUserId, UserPassword $userPassword);
}
