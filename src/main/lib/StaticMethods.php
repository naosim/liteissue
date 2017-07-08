<?php
declare(strict_types=1);

function eachArgs($args, $consumer_k_v) {
  foreach($args as $value) {
    $c = get_class($value);
    $key = strtolower(substr($c, 0, 1)) . substr($c, 1);
    $consumer_k_v($key, $value);
  }
}
