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
    return self::of($a);
  }

  function map($f): Stream {
    $a = [];
    foreach ($this->ary as $k => $v) {
      $a[] = $f($v, $k);
    }
    return self::of($a);
  }

  function forEach($f): void {
    foreach ($this->ary as $k => $v) {
      $f($v, $k);
    }
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

  function count(): int {
    return count($this->ary);
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
