<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once __DIR__ . '/../src/EnumGenerator.class.php';

/**
 *  test case.
 */
class EnumGeneratorTest extends PHPUnit_Framework_TestCase
{

  
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
   * @testdox ::getInstance() should return an instance of EnumGenerator
   */
  public function getInstanceReturnEnumGenerator()
  {
    $o = EnumGenerator::getInstance();
    $this->assertTrue($o instanceof EnumGenerator);
  }


}

