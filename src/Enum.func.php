<?php

function Enum($class, $instances, $namespace = null)
{
  return EnumGenerator::getInstance()->compil($class, $instances, $namespace = null);
}

