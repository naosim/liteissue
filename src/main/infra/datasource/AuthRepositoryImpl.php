<?php
declare(strict_types=1);

class AuthRepositoryImpl implements AuthRepository {
  function __construct(
    JsonIO $jsonIO
  ) {
    eachArgs(func_get_args(), function($k, $v){ $this->$k = $v; });
  }

  public function auth(UserId $userId, UserPassword $password): AuthedUserId {
    $json = $this->jsonIO->load();

    $userJson;
    foreach($json as $user) {
      if($user->id == $userId->getValue()) {
        $userJson = $user;
      }
    }
    if(isset($userJson->default_password) && $userJson->default_password == $password->getValue()) {
      return new AuthedUserId($userId);
    }
    if(isset($userJson->password) && $userJson->password == md5($password->getValue())) {
      return new AuthedUserId($userId);
    }
    return false;
  }

  public function updatePassword(AuthedUserId $authedUserId, UserPassword $userPassword) {

  }
}
