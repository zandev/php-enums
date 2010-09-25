<?php

interface Enum
{

  public function getName();
  public function getValue();
  public function getOrdinal();
  public function getBinary();
  public static function iterator();
}