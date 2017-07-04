<?php
class Stream {
  private $ary;
  function __construct($ary) {
    $this->ary = $ary !== null ? $ary : [];
  }

  function filter($f): Stream {
    $a = [];
    foreach ($this->ary as $k => $v) {
      if($f($v, $k)) {
        $a[] = $v;
      }
    }
    return self::ofAll($a);
  }

  function map($f): Stream {
    $a = [];
    foreach ($this->ary as $k => $v) {
      $a[] = $f($v, $k);
    }
    return self::ofAll($a);
  }

  function peek($f): Stream {
    $this->map($f);
    return $this;
  }

  function forEach($f): void {
    $this->peek($f);
  }

  function reduce($f_memo_v, $memo) {
    foreach ($this->ary as $k => $v) {
      $memo = $f_memo_v($memo, $v, $k);
    }
    return $memo;
  }

  function toArray() {
    return $this->ary;
  }

  function toJson() {
    return json_encode($this->toArray());
  }

  function count(): int {
    return count($this->ary);
  }

  /**
   * Get the first value or throw if list is empty
   */
  function get() {
    return $this->getOrThrow(function(){ return new RuntimeException('array is empty'); });
  }

  /**
   * Get the first value or $default param if list is empty
   */
  function getOrElse($default) {
    if(count() == 0) {
      return $default;
    }
    return $this->toArray()[0];
  }

  function getOrThrow($f) {
    if(count() == 0) {
      throw $f();
    }
    return $this->toArray()[0];
  }

  function isEmpty(): boolean {
    return $this->count() === 0;
  }

  function isDefined(): boolean {
    return !$this->isEmpty();
  }


  public static function ofAll($ary) {
    return new Stream($ary);
  }

  public static function of(...$v) {
    return new Stream($v);
  }
}
