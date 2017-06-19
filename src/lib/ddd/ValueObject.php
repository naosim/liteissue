<?php
class StringVO {
  private $value; // string
  function __construct(string $value) {
       $this->value = $value;
   }
   public function getValue() {
     return $this->value;
   }
}
class DateTimeVO {
  private $value; // DateTime
  function __construct(DateTime $value) {
       $this->value = $value;
   }

   public function getValue() {
     return $this->value;
   }
}
