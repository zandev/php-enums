<?php


require_once 'PHPUnit/Framework/TestCase.php';


/**
 *  test case.
 */
class EnumTestCase extends PHPUnit_Framework_TestCase
{

  protected $tmpDir;

  public function mkTmpDir()
  {
    $this->tmpDir = __DIR__ . '/tmp';
    $this->rmTmpDir();
    mkdir($this->tmpDir);
  }

  public function rmTmpDir()
  {
    `rm -rf $this->tmpDir`;
  }

  /**
   * Prepares the environment before running a test.
   */
  protected function setUp()
  {
    parent::setUp();
    $this->mkTmpDir();
  }

  /**
   * Cleans up the environment after running a test.
   */
  protected function tearDown()
  {
    $this->rmTmpDir();
    parent::tearDown();
  }
}

