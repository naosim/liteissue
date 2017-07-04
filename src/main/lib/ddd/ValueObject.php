<?php
declare(strict_types=1);

class StringVO {
  protected $value; // string
  function __construct(string $value) {
       $this->value = $value;
   }
   public function getValue(): string {
     return $this->value;
   }
}
class DateTimeVO {
  protected $value; // DateTime
  function __construct(DateTime $value) {
      $value->setTimeZone( new DateTimeZone('Asia/Tokyo'));
       $this->value = $value;
   }

   public function getValue(): DateTime {
     return $this->value;
   }

   public function getApiValue(): String {
     return $this->value->format(DateTime::ISO8601);
   }

   public function getDbValue(): int {
     return $this->value->getTimestamp();
   }
}

class UnixTimestampVO {
  protected $value; // DateTime
  function __construct(int $value) {
       $this->value = $value;
   }

   public function getValue(): int {
     return $this->value;
   }

   public function toDateTime(): DateTime {
     return new DateTime('@' . $this->getValue());
   }
}
