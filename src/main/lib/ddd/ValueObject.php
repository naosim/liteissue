<?php
declare(strict_types=1);

class StringVO {
  protected $value; // string
  function __construct(string $value) {
       $this->value = $value;
   }
   public function getValue() {
     return $this->value;
   }
}
class DateTimeVO {
  protected $value; // DateTime
  function __construct(DateTime $value) {
       $this->value = $value;
   }

   public function getValue() {
     return $this->value;
   }
}
