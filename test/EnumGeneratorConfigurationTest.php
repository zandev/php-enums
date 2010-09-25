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
}

