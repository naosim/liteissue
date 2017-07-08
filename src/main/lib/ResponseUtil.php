<?php

class ResponseUtil {
  static function ok($ary) {
    return array(
      "status" => array(
        "code" => 200
      ),
      "result" => $ary
    );
  }

  static function ng(RuntimeException $e) {
    return array(
      "status" => array(
        "code" => 500
      ),
      "error" => array(
        "type" => get_class($e),
        "message" => $e->getMessage(),
        "trace" => $e->getTrace(),
      )
    );
  }
}
