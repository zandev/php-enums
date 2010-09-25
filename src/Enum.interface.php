<?php

interface Enum
{

  public function getOrdinal();
  public function getBinary();
  public function getValue();
  public static function iterator();
}