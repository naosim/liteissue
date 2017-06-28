<?php
interface DateTimeFactory {
  public function createDateTime(): DateTime;
  public function createUnixDateTime(): int;
}
class DateTimeFactoryImpl implements DateTimeFactory {
  public function createDateTime(): DateTime {
    return new DateTime();
  }

  public function createUnixDateTime(): int {
    return (new DateTime())->getTimestamp();
  }
}
