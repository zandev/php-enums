Here is a library for handling type-safe enumerations in php:

This library handle classes generation, classes caching, namespaces, while implementing the "Type Safe Enumeration" design pattern, with several helper methods for dealing with enums, like retrieving an ordinal for enums sorting, or retrieving a binary value, for enums combinations.

The generated code use a plain old php template file, which is also configurable, so you can provide your own template.

It is full test covered with phpunit.

#Version 0.1
The library is well tested, with a near 100% coverage

#TODO
Add support for parameterized value's type, because having values of different types for each instance of a given Enum is absolutely error prone.

#Usage: (@see usage.php, or unit tests for more details)

    <?php
    require_once __DIR__ . '/src/Enum.func.php';
    @mkdir(__DIR__ . '/cache');
    EnumGenerator::setDefaultCachedClassesDir(__DIR__ . '/cache');
    
    //Class definition is evaluated on the fly:
    Enum('FruitsEnum', array('apple' , 'orange' , 'rasberry' , 'bannana'));
    
    //Class definition is cached in the cache directory for later usage:
    Enum('CachedFruitsEnum', array('apple' , 'orange' , 'rasberry' , 'bannana'), '\my\company\name\space', true);
    
    echo 'FruitsEnum::APPLE() == FruitsEnum::APPLE(): ';
    var_dump(FruitsEnum::APPLE() == FruitsEnum::APPLE()) . "\n";
    
    echo 'FruitsEnum::APPLE() == FruitsEnum::ORANGE(): ';
    var_dump(FruitsEnum::APPLE() == FruitsEnum::ORANGE()) . "\n";
    
    echo 'FruitsEnum::APPLE() instanceof Enum: ';
    var_dump(FruitsEnum::APPLE() instanceof Enum) . "\n";
    
    echo 'FruitsEnum::APPLE() instanceof FruitsEnum: ';
    var_dump(FruitsEnum::APPLE() instanceof FruitsEnum) . "\n";
    
    echo "->getName()\n";
    foreach (FruitsEnum::iterator() as $enum)
    {
      echo "  " . $enum->getName() . "\n";
    }
    
    echo "->getValue()\n";
    foreach (FruitsEnum::iterator() as $enum)
    {
      echo "  " . $enum->getValue() . "\n";
    }
    
    echo "->getOrdinal()\n";
    foreach (CachedFruitsEnum::iterator() as $enum)
    {
      echo "  " . $enum->getOrdinal() . "\n";
    }
    
    echo "->getBinary()\n";
    foreach (CachedFruitsEnum::iterator() as $enum)
    {
      echo "  " . $enum->getBinary() . "\n";
    }
    
Output:

    FruitsEnum::APPLE() == FruitsEnum::APPLE(): bool(true)
    FruitsEnum::APPLE() == FruitsEnum::ORANGE(): bool(false)
    FruitsEnum::APPLE() instanceof Enum: bool(true)
    FruitsEnum::APPLE() instanceof FruitsEnum: bool(true)

    Namespace support: 
    object(my\company\name\space\CachedFruitsEnum)#4 (4) {
      ["name":"my\company\name\space\CachedFruitsEnum":private]=>
      string(5) "APPLE"
      ["value":"my\company\name\space\CachedFruitsEnum":private]=>
      string(3) "pig"
      ["ordinal":"my\company\name\space\CachedFruitsEnum":private]=>
      int(1)
      ["binary":"my\company\name\space\CachedFruitsEnum":private]=>
      int(1)
    }

    File caching: 
    class: FruitsEnum
    File: /home/stephane/Private/php-enums/src/EnumGenerator.class.php(165) : eval()'d code
    class: my\company\name\space\CachedFruitsEnum
    File: /home/stephane/Private/php-enums/cache/CachedFruitsEnum.enum.php

    ->getName()
      APPLE
      ORANGE
      RASBERRY
      BANNANA

    ->getValue()
      apple
      orange
      rasberry
      bannana

    ->getValue() when values have been specified
      pig
      dog
      cat
      bird

    ->getOrdinal()
      1
      2
      3
      4

    ->getBinary()
      1
      2
      4
      8

    /*cast:*/ (string) $enum
      APPLE
      ORANGE
      RASBERRY
      BANNANA


