<?php
declare(strict_types=1);

include_once "loader.php";
setupInclude('.');

Logger::log("hoge");
Logger::dump("hoge");
exit();

// $authRepository = new AuthRepositoryImpl(new JsonIO("./data/auth.json"));
// var_dump($authRepository->auth(new UserId("admin"), new UserPassword("admin")));
// if(
//   !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])
//   || !$userRepository->auth(new UserId($_SERVER['PHP_AUTH_USER']), new UserPassword($_SERVER['PHP_AUTH_PW']))
// ) {
//   header('WWW-Authenticate: Basic realm="Enter username and password."');
//   header('Content-Type: text/plain; charset=utf-8');
//   die('このページを見るにはログインが必要です');
// }

// setup
$sqliteWrapperFactory = new SQLiteWrapperFactory();
$issueRepository = new IssueRepositoryImpl(
  $sqliteWrapperFactory,
  new DateTimeFactoryImpl(),
  new AuthedUserId(new UserId('admin'))
);

// API
function get_get() {
  return "hoge";
}

function get_throw() {
  throw new RuntimeException("ぷぎゃー");
}

function get_issues() {
  global $issueRepository;
  $stream = $issueRepository->findAll();
  return $stream->map(function($v){ return $v->toMap(); })->toArray();
}

function post_issues() {
  var_dump("aa");
  global $issueRepository;
  $title = $_POST["title"];
  $description = $_POST["description"];
  $status = "open";

  $c = new IssueContainer(
    new IssueTitle($title),
    new IssueDescription($description),
    new IssueStatusOpen()
  );

  var_dump($issueRepository->insert($c));
  return "hoge";
}

if(
  !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])
  || $_SERVER['PHP_AUTH_USER'] !== 'admin'
  || $_SERVER['PHP_AUTH_PW'] !== 'admin') {
  header('WWW-Authenticate: Basic realm="Enter username and password."');
  header('Content-Type: text/plain; charset=utf-8');
  die('このページを見るにはログインが必要です');
}

function getMethod() {
  if(!isset($_GET["method"])) {
    return false;
  }
  $type = strtolower($_SERVER["REQUEST_METHOD"]);
  $methodName = $type . "_" . $_GET["method"];
  if(!function_exists($methodName)) {
    return false;
  }
  return $methodName;
}

$method = getMethod();
if(!$method) {
  echo file_get_contents('public/form.html');
  exit();
}

header('Content-Type: application/json; charset=utf-8');
try {
  echo json_encode(ResponseUtil::ok($method()));
} catch(RuntimeException $e) {
  http_response_code(500);
  echo json_encode(ResponseUtil::ng($e));
}
