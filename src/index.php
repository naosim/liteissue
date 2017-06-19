<?php
include_once "loader.php";
$authRepository = new AuthRepositoryImpl(new JsonIO("./data/auth.json"));
var_dump($authRepository->auth(new UserId("admin"), new UserPassword("admin")));
// if(
//   !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])
//   || !$userRepository->auth(new UserId($_SERVER['PHP_AUTH_USER']), new UserPassword($_SERVER['PHP_AUTH_PW']))
// ) {
//   header('WWW-Authenticate: Basic realm="Enter username and password."');
//   header('Content-Type: text/plain; charset=utf-8');
//   die('このページを見るにはログインが必要です');
// }
