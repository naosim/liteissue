<?php
class UserRepositoryImpl implements UserRepository {
  public function find(UserId $userId) {
    return new User($userId, new UserName("hoge"));
  }
  public function auth(UserId $userId, UserPassword $password) {
    $json = loadJson("./data/user.json");

    $userJson;
    foreach($json as $user) {
      if($user->id == $userId->getValue()) {
        $userJson = $user;
      }
    }
    if(isset($userJson->default_password) && $userJson->default_password == $password->getValue()) {
      return true;
    }
    if(isset($userJson->password) && $userJson->password == md5($password->getValue())) {
      return true;
    }
    return false;
  }

  public function updatePassword(AuthedUserId $authedUserId, UserPassword $userPassword) {

  }
}
