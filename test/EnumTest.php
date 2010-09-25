<?php

require_once __DIR__ . '/EnumTestCase.class.php';
require_once __DIR__ . '/../src/EnumGenerator.class.php';

/**
 *  @backupStaticAttributes enabled
 */
class EnumTest extends EnumTestCase
{

  private $enumFile;

  public function __construct()
  {
    if (! class_exists('FruitsEnum'))
    {
      EnumGenerator::setDefaultCachedClassesDir($this->tmpDir);
      $this->enumFile = EnumGenerator::getInstance()->compil('FruitsEnum', array('apple' , 'orange' , 'rasberry' , 'bannana'));
      require_once $this->enumFile;
    }
  }

  public function __destruct()
  {
    if (file_exists($this->enumFile))
    {
      unlink($this->enumFile);
    }
  }

  /**
   * Prepares the environment before running a test.
   */
  protected function setUp()
  {
    parent::setUp();
    //
  }

  /**
   * Cleans up the environment after running a test.
   */
  protected function tearDown()
  {
    //
    parent::tearDown();
  }

  /**
   * @test
   * @testdox the generated enum class should not be be instanciable
   */
  public function enumIsNotInstanciable()
  {
    $ref = new ReflectionClass('FruitsEnum');
    $this->assertFalse($ref->getConstructor()->isPublic());
  }

  /**
   * @test
   * @testdox the generated instances static getters should be uppcase
   */
  public function enumHasUppcaseInstancesStaticGetters()
  {
    $ref = new ReflectionClass('FruitsEnum');
    $this->assertEquals('APPLE', $ref->getMethod('apple')->getName());
  }

  /**
   * @test
   * @testdox the generated enum class should have static getters for each enum instance
   */
  public function enumHasInstancesStaticGetters()
  {
    $ref = new ReflectionClass('FruitsEnum');
    $this->assertTrue($ref->getMethod('APPLE')->isStatic());
    $this->assertTrue($ref->getMethod('ORANGE')->isStatic());
    $this->assertTrue($ref->getMethod('RASBERRY')->isStatic());
  }

  /**
   * @test
   * @testdox the generated instances static getters should return a self instance
   */
  public function enumInstancesStaticGettersIsTypeOfSelf()
  {
    $this->assertTrue(FruitsEnum::APPLE() instanceof FruitsEnum);
  }

  /**
   * @test
   * @testdox the generated instances static getters should return a singleton
   */
  public function enumInstancesStaticGettersReturnSingleton()
  {
    $this->assertEquals(FruitsEnum::APPLE(), FruitsEnum::APPLE());
  }

  /**
   * @test
   * @testdox different enums instances should not be equals
   */
  public function enumInstancesShouldNotBeEquals()
  {
    $this->assertNotEquals(FruitsEnum::APPLE(), FruitsEnum::ORANGE());
  }

  /**
   * @test
   * @testdox the enum instances should implements Enum
   */
  public function enumInstancesImplementsEnum()
  {
    $this->assertTrue(FruitsEnum::APPLE() instanceof Enum);
  }

  /**
   * @test
   * @testdox Enum::getName() return the getter method's name
   */
  public function getName()
  {
    $this->assertEquals('APPLE', FruitsEnum::APPLE()->getName());
    $this->assertEquals('ORANGE', FruitsEnum::ORANGE()->getName());
    $this->assertEquals('RASBERRY', FruitsEnum::RASBERRY()->getName());
    $this->assertEquals('BANNANA', FruitsEnum::BANNANA()->getName());
  }

  /**
   * @test
   * @testdox Enum::getOrdinal() return the correct ordinal
   */
  public function getOrdinal()
  {
    $this->assertEquals(1, FruitsEnum::APPLE()->getOrdinal());
    $this->assertEquals(2, FruitsEnum::ORANGE()->getOrdinal());
    $this->assertEquals(3, FruitsEnum::RASBERRY()->getOrdinal());
    $this->assertEquals(4, FruitsEnum::BANNANA()->getOrdinal());
  }

  /**
   * @test
   * @testdox Enum::getBinary() return a pow of base 2
   */
  public function getBinary()
  {
    $this->assertEquals(1, FruitsEnum::APPLE()->getBinary());
    $this->assertEquals(2, FruitsEnum::ORANGE()->getBinary());
    $this->assertEquals(4, FruitsEnum::RASBERRY()->getBinary());
    $this->assertEquals(8, FruitsEnum::BANNANA()->getBinary());
  }

  
  /**
   * @test
   * @testdox Enum::getValue() return a default value
   */
  public function getValueWithDefault()
  {
    $this->assertEquals('apple', FruitsEnum::APPLE()->getValue());
    $this->assertEquals('orange', FruitsEnum::ORANGE()->getValue());
    $this->assertEquals('rasberry', FruitsEnum::RASBERRY()->getValue());
    $this->assertEquals('bannana', FruitsEnum::BANNANA()->getValue());
  }
  
  /**
   * @test
   * @testdox Enum::getValue() return the correct value
   */
  public function getValueWithAssignedValues()
  {
    EnumGenerator::getInstance()->evaluate('EnumWithValues', array('apple' => 12 , 'orange' => 27 , 'rasberry' => 33 , 'bannana' => 401));
    $this->assertEquals(12, EnumWithValues::APPLE()->getValue());
    $this->assertEquals(27, EnumWithValues::ORANGE()->getValue());
    $this->assertEquals(33, EnumWithValues::RASBERRY()->getValue());
    $this->assertEquals(401, EnumWithValues::BANNANA()->getValue());
  }
}

