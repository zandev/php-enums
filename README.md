This library provide support for type-safe enumerations in php.

Usage:

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