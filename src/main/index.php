<?php
declare(strict_types=1);

class Mapper {
  static function toDbMap(...$args) {
    $ary = [];
    foreach($args as $v) {
      $c = get_class($v);
      $key = strtolower(substr($c, 0, 1)) . substr($c, 1);
      if(method_exists($v, 'getDbValue')) {
        $ary[$key] = $v->getDbValue();
      } else if(method_exists($v, 'getValue')) {
        $ary[$key] = $v->getValue();
      } else if(method_exists($v, 'getTimestamp')) {
        $ary[$key] = $v->getTimestamp();
      } else {
        $ary[$key] = $v;
      }
    }
    return $ary;
  }

  static function toApiMap(...$args) {
    $ary = array();
    foreach($args as $v) {
      $c = get_class($v);
      $key = strtolower(substr($c, 0, 1)) . substr($c, 1);
      if(method_exists($v, 'getApiValue')) {
        $ary[$key] = $v->getApiValue();
      } else if(method_exists($v, 'getValue')) {
        $ary[$key] = $v->getValue();
      } else {
        $ary[$key] = $v;
      }
    }
    return $ary;
  }
}

class Required {
  static function get($key) {
    if(!isset($_GET[$key])) {
      throw new RuntimeException("必須パラメータ: $key");
    }
    return $_GET[$key];
  }

  static function post($key) {
    if(!isset($_POST[$key])) {
      throw new RuntimeException("必須パラメータ: $key");
    }
    return $_POST[$key];
  }
}



include_once "loader.php";
setupInclude('.');
//
// Logger::log("hoge");
// Logger::dump("hoge");
// exit();

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
$authedUserId = new AuthedUserId(new UserId('admin'));

$sqliteWrapperFactory = new SQLiteWrapperFactory();
$issueRepository = new IssueRepositoryImpl(
  $sqliteWrapperFactory,
  new DateTimeFactoryImpl(),
  $authedUserId
);
$messageRepository = new MessageRepositoryImpl(
  $sqliteWrapperFactory,
  new DateTimeFactoryImpl(),
  $authedUserId
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
  global $issueRepository;
  $status = "open";

  $c = new IssueContainer(
    new IssueTitle(Required::post('title')),
    new IssueDescription(Required::post('description')),
    new IssueStatusOpen()
  );
  $issueRepository->insert($c);
  return 'ok';
}

function get_messages() {
  global $messageRepository;
  $issueId = new IssueId(Required::get('issue_id'));
  $stream = $messageRepository->findAll($issueId);
  return $stream->map(function($v){ return $v->toApiMap(); })->toArray();
}

function post_messages() {
  global $messageRepository;
  $messageRepository->insert(new MessageContainer(
    new IssueId(Required::post('issue_id')),
    new MessageDescription(Required::post('message_description'))
  ));
  return array('result' => 'ok');
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
