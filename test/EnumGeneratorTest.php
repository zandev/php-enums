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
    $this->tmpDir = __DIR__ . '/tmp';
    restore_error_handler();
  }

  /**
   * Prepares the environment before running a test.
   */
  protected function setUp()
  {
    parent::setUp();
    `rm -rf $this->tmpDir`;
    mkdir($this->tmpDir);
    EnumGenerator::setDefaultCachedClassesDir($this->tmpDir);
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
   * @testdox ->build() return a valid filename
   */
  public function buildReturnvalidFilename()
  {
    $f = EnumGenerator::getInstance()->compil('MySecondEnum', array('apple'));
    $this->assertFileExists($f);
  }
}

