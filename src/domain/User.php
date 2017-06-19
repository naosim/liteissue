<?php
class UserId extends StringVO {}
class AuthedUserId extends UserId {
  function __construct(UserId $userId) {
    $this->value = $userId->value;
  }
}
class UserName extends StringVO {}

class User {
  function __construct(
    UserId $userId,
    UserName $userName
  ) {
    eachArgs(func_get_args(), function($k, $v){ $this->$k = $v; });
  }
}

interface UserRepository {
  public function find(UserId $userId);

}
