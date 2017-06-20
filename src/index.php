<?php
declare(strict_types=1);

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

// $handle = sqlite_open('sample.db');
// sqlite_query($handle, 'create table sample(name TEXT)');
// var_dump(sqlite_query($handle, 'select * from sample'));

// $pdo = new PDO('sqlite:sample.db');
// // SQL実行時にもエラーの代わりに例外を投げるように設定
// // (毎回if文を書く必要がなくなる)
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// // デフォルトのフェッチモードを連想配列形式に設定
// // (毎回PDO::FETCH_ASSOCを指定する必要が無くなる)
// $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//
// $stmt = $pdo->prepare("SELECT * FROM sample");
// $stmt->execute();
$r2 = selectSql('sample.db', 'SELECT * FROM sample', []);
var_dump($r2[0]['name']);
