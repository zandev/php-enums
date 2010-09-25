<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once __DIR__ . '/../src/EnumGenerator.class.php';

/**
 *  @backupStaticAttributes enabled
 */
class EnumGeneratorTest extends PHPUnit_Framework_TestCase
{

  private $tmpDir;

  public function __construct()
  {
    `rm -rf $this->tmpDir`;
    $this->tmpDir = __DIR__ . '/tmp';
    restore_error_handler();
  }

  /**
   * Prepares the environment before running a test.
   */
  protected function setUp()
  {
    parent::setUp();
    mkdir($this->tmpDir);
  }

  /**
   * Cleans up the environment after running a test.
   */
  protected function tearDown()
  {
    `rm -rf $this->tmpDir`;
    parent::tearDown();
  }

  /**
   * @test
   * @testdox ::getInstance() should return an instance of EnumGenerator
   */
  public function getInstanceReturnEnumGenerator()
  {
    $o = EnumGenerator::getInstance();
    $this->assertTrue($o instanceof EnumGenerator);
  }

  /**
   * @test
   * @testdox ::getInstance() called without any parameters should return the default instance
   */
  public function getInstanceWithoutParamsReturnDefault()
  {
    $a = EnumGenerator::getInstance();
    $b = EnumGenerator::getInstance('default');
    
    $this->assertEquals($a, $b);
  }

  /**
   * @test
   * @testdox ::getInstance() called with null as it's first parameter should return the default instance
   */
  public function getInstanceWithNullParamsReturnDefault()
  {
    $a = EnumGenerator::getInstance();
    $b = EnumGenerator::getInstance(null);
    
    $this->assertEquals($a, $b);
  }

  /**
   * @test
   * @testdox ::getInstance() called with a non existent cache directory should raise an exception
   * @expectedException InvalidArgumentException
   */
  public function getInstanceWithBadCacheDirRaiseError()
  {
    EnumGenerator::getInstance(null, null, 'bad-dir');
  }

  /**
   * @test
   * @testdox ::getInstance() called with a non existent template file should raise an exception
   * @expectedException InvalidArgumentException
   */
  public function getInstanceWithBadTemplateRaiseError()
  {
    EnumGenerator::getInstance(null, 'bad-template');
  }

  /**
   * @test
   * @testdox an instance should have a valid default templateFile
   */
  public function instanceShouldHaveValidDefaultTemplateFile()
  {
    $f = EnumGenerator::getInstance()->getTemplateFile();
    $this->assertFileExists($f);
  }

  /**
   * @test
   * @testdox an instance should have a default cached classes directory
   */
  public function instanceShouldHaveDefaultCachedDir()
  {
    $d = EnumGenerator::getInstance()->getCachedClassesDir();
    $this->assertNotNull($d);
  }

  /**
   * @test
   * @testdox ::setDefaultTemplateFile() should set default
   */
  public function settingDefaultTemplateFile()
  {
    $f = $this->tmpDir . '/dummy.tpl.php';
    touch($f);
    EnumGenerator::setDefaultTemplateFile($f);
    $this->assertEquals($f, EnumGenerator::getInstance()->getTemplateFile());
  }

  /**
   * @test
   * @testdox ::setDefaultCachedClassesDir() should set default
   */
  public function settingDefaultCachedClassesDir()
  {
    $d = $this->tmpDir . '/dummy-caching';
    mkdir($d);
    EnumGenerator::setDefaultCachedClassesDir($d);
    $this->assertEquals($d, EnumGenerator::getInstance()->getCachedClassesDir());
  }

  /**
   * @test
   * @testdox ->generate() should return a string
   */
  public function generateReturnString()
  {
    $r = EnumGenerator::getInstance()->generate('dummy', array('orange'));
    $this->assertTrue(is_string($r));
  }

  /**
   * @test
   * @testdox ->generate() should return a valid php content
   */
  public function generateValidPhpContent()
  {
    set_error_handler(function($errno, $errstr, $errfile, $errline)use(&$hasError){
      throw new PHPUnit_Framework_Error($errstr);
    });
    $r = EnumGenerator::getInstance()->generate('dummy', array('apple'));
    eval($r);
    $this->assertTrue(true);
  }

  /**
   * @test
   * @testdox ->generate() $instances parameter should be a non empty array
   * @expectedException InvalidArgumentException
   */
  public function generateInstancesParameterShouldNotBeEmpty()
  {
    EnumGenerator::getInstance()->generate('MyEnum', array());
  }

  /**
   * @test
   * @testdox ->generate() should return a valid class definition
   */
  public function generateValidClassDef()
  {
    $r = EnumGenerator::getInstance()->generate('MyFirstEnum', array('apple'));
    eval($r);
    $this->assertTrue(class_exists('MyFirstEnum'));
  }

  /**
   * @test
   * @testdox the generated enum class should not be be instanciable
   */
  public function enumIsNotInstanciable()
  {
    $r = EnumGenerator::getInstance()->generate('MySecondEnum', array('apple'));
    eval($r);
    $ref = new ReflectionClass('MySecondEnum');
    $this->assertFalse($ref->getConstructor()->isPublic());
  }

  /**
   * @test
   * @testdox the generated instances static getters should be uppcase
   */
  public function enumHasUppcaseInstancesStaticGetters()
  {
    $r = EnumGenerator::getInstance()->generate('MyThirdEnum', array('apple'));
    eval($r);
    $ref = new ReflectionClass('MyThirdEnum');
    $this->assertTrue($ref->hasMethod('apple'));
    $this->assertTrue($ref->hasMethod('Apple'));
    $this->assertTrue($ref->hasMethod('APPLE'));
  }

  /**
   * @test
   * @testdox the generated enum class should have static getters for each enum instance
   */
  public function enumHasInstancesStaticGetters()
  {
    $r = EnumGenerator::getInstance()->generate('Fruits', array('apple' , 'orange' , 'rasberry'));
    eval($r);
    $ref = new ReflectionClass('Fruits');
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
    $r = EnumGenerator::getInstance()->generate('OneMoreEnum', array('apple'));
    eval($r);
    $this->assertTrue(OneMoreEnum::APPLE() instanceof OneMoreEnum);
  }
  
  /**
   * @test
   * @testdox the generated instances static getters should return a singleton
   */
  public function enumInstancesStaticGettersReturnSingleton()
  {
    $r = EnumGenerator::getInstance()->generate('OneMoreFruitEnum', array('apple', 'orange'));
    eval($r);
    $this->assertEquals(OneMoreFruitEnum::APPLE(), OneMoreFruitEnum::APPLE());
    $this->assertNotEquals(OneMoreFruitEnum::APPLE(), OneMoreFruitEnum::ORANGE());
  }


}

